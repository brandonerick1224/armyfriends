var watchify = require('watchify');
var browserify = require('browserify');
var gulp = require('gulp');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var gutil = require('gulp-util');
var sourcemaps = require('gulp-sourcemaps');
var assign = require('lodash.assign');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');

var paths = {
  index: './resources/assets/js/index.js',
  dest: './public/assets/js/',
};

var vendors = [
  './node_modules/ladda/js/spin.js',
  './node_modules/ladda/js/ladda.js',
  './node_modules/ladda/js/ladda.jquery.js',
];

// add custom browserify options here
var customOpts = {
  entries: paths.index,
  debug: true,
  transform: [['babelify', { 'presets': ['es2015'] }], 'vueify'],
  presets: ['es2015', 'stage-2'],
};
var opts = assign({}, watchify.args, customOpts);
var b = watchify(browserify(opts));

gulp.task('scripts', bundle); // script task runs bundle
b.on('update', bundle); // on any dep update, runs the bundler
b.on('log', gutil.log); // output build logs to terminal

function bundle() {
  return b.bundle()
    // log errors if they happen
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe(source('bundle.js'))
    // optional, remove if you don't need to buffer file contents
    .pipe(buffer())
    // optional, remove if you dont want sourcemaps
    .pipe(sourcemaps.init({loadMaps: true})) // loads map from browserify file
    // Add transformation tasks to the pipeline here.
    // .pipe(uglify())
    .pipe(sourcemaps.write('./')) // writes .map file
    .pipe(gulp.dest(paths.dest));
}

gulp.task('vendor', function() {
  return gulp.src(vendors)
    .pipe(concat('vendor.js'))
    .pipe(gulp.dest(paths.dest))
    .pipe(rename('vendor.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.dest));
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['vendor', 'scripts']);
