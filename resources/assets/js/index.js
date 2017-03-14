import vueResource from 'vue-resource';
import vuePlugin from './vue-plugin';
import comments from './components/comments/comments.vue';
import Vue from 'vue';

window.Vue = Vue;

/**
 * Plugins
 */
Vue.use(vueResource);
Vue.use(vuePlugin);

/**
 * Global components
 */
Vue.component('comments', comments);

/**
 * Global Settings
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = $('#meta-csrf-token').attr('content');

/**
 * Root Vue component
 */
var vueRoot = window.vueRoot = new Vue({
  el: 'body',
});
