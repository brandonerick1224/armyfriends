require('dotenv').load();
var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var mysql = require('mysql');
var Ioredis = require('ioredis');
var Redis = require('redis');

var DEBUG = process.env.APP_DEBUG;

// Server handler, used with http.createServer
function handler(req, res) {
  res.writeHead(200);
  res.end('');
}

/**
 * Connect to Database
 */
var database = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_DATABASE,
});

/**
 * Initialize Redis
 */
var ioredis = new Ioredis({
  port: process.env.REDIS_PORT,
  db: process.env.REDIS_DATABASE,
});

var redis = Redis.createClient({
  port: process.env.REDIS_PORT,
});
redis.select(process.env.REDIS_DATABASE);
redis.flushdb();

/**
 * Listen to socket connections
 */
app.listen(process.env.SOCKET_IO_PORT, function() {
  if (DEBUG) console.log('Server is running and listening ' + process.env.SOCKET_IO_PORT + ' port');
});

// Connected users lists
var connectedUsers = {};


/* ========================================================================= *\
 * Handle web socket connection and disconnection
\* ========================================================================= */

/**
 * On connection
 */
io.on('connection', function(socket) {
  var query = socket.handshake.query;

  if (DEBUG) console.log('Connection: ' + socket.handshake.headers['user-agent'] + ' ' + JSON.stringify(query));
  if (DEBUG) console.log('Connecter user: ' + query.token);

  /**
   * Authorize user and fill Redis data
   */
  tokenExists(query.token, {
    // Authorized
    true: function() {
      // Add to users list on connect
      connectedUsers[query.token] = socket;
      // Add to Redis users list
      redis.sadd('users', query.token);
      // Listen to objects
      addListeners(query.token, query.listen_to);
    },
    // Not authorized
    false: function() {
      if (DEBUG) console.log('Cant find socket token in DB: ' + query.token);
      socket.disconnect();
    }
  });

  /**
   * On disctonnection
   */
  socket.on('disconnect', function() {
    if (DEBUG) console.log('Disconnected user: ' + query.token);
    // Remove from users list
    delete connectedUsers[query.token];
    // Remove from Redis users list
    redis.srem('users', query.token);
    // Remove listeners
    removeListeners(query.token, query.listen_to);
  });
});


/* ========================================================================= *\
 * Subscribe Redis and pass messages to needed websocket
\* ========================================================================= */

// Subscribe to all events
ioredis.psubscribe('*', function(err, count) {});

/**
 * Send message to appropriate user when recieved from Redis
 */
ioredis.on('pmessage', function(subscribed, channel, message) {
  if (DEBUG) console.log('Message Recieved: ' + message);
  message = JSON.parse(message);

  if (connectedUsers[channel] !== undefined) {
    if (DEBUG) console.log('Sent message to: ' + channel);
    connectedUsers[channel].emit(channel, message.data);
  }
});


/* ========================================================================= *\
 * Helper functions
\* ========================================================================= */

/**
 * Check if token exists in database
 *
 * @param token
 * @param cbs
 */
function tokenExists(token, cbs) {

  database.getConnection(function(err, connection) {
    if (err) throw err;

    connection.query({
      sql: 'SELECT count(*) as cnt FROM users WHERE socket_token = ?',
      timeout: 400, // 40s
      values: [token]
    }, function(err, rows, fields) {
      if (err) throw err;

      if (rows[0].cnt == 0) {
        cbs.false();
      } else {
        cbs.true();
      }

      connection.release();
    });
  });
}

/**
 * Add listeners to objects on Redis
 *
 * @param token
 * @param listenTo
 */
function addListeners(token, listenTo) {
  if (typeof listenTo === 'undefined') return;

  var objects = listenTo.split(',');
  // Skip emtpy string
  if (objects.length === 1 && objects[0] === '') return;

  objects.map(function(object) {
    redis.sadd(object, token);
  });
}

/**
 * Remove listeners from objects on Redis
 *
 * @param token
 * @param listenTo
 */
function removeListeners(token, listenTo) {
  if (typeof listenTo === 'undefined') return;

  var objects = listenTo.split(',');
  // Skip emtpy string
  if (objects.length === 1 && objects[0] === '') return;

  objects.map(function(object) {
    redis.srem(object, token);
  });
}
