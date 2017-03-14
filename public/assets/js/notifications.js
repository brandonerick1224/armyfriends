(function($) {
  "use strict";

  var socket;

  /**
   * Initialize websokets
   */
  function initWebSockets() {
    // Establish connection
    socket = io(app.socket.url, {query: {
      token: app.socket.token,
      listen_to: getListenTo(),
    }});
    // Listen to channel
    socket.on(app.socket.token, onMessage);
  }

  /**
   * Get list of objects to listen to
   */
  function getListenTo() {
    var objects = [];

    $('[data-listen-to]').each(function(idx, item) {
      objects.push($(item).data('listen-to'));
    });

    return objects;
  }
  
  /**
   * On message recieved
   *
   * @param message
   */
  function onMessage(message) {
    console.log(message)

    switch (message.event) {
      case 'MessageEvent':
        return handleMessageEvent(message.data);
      case 'NotificationEvent':
        return handleNotificationEvent(message.data);
      case 'CommentEvent':
        return dispatchVueMesage(message.data);
    }
  }

  /**
   * Dispatch messave for Vue application
   *
   * @param message
   */
  function dispatchVueMesage(data) {
    var key = 'socketio-' + data.key;
    vueRoot.$broadcast(key, data);
  }

  /**
   * Handle MessageEvent
   *
   * @param data
   */
  function handleMessageEvent(data) {
    $.notify(data.message, {
      autoHide: true,
      autoHideDelay: 30000,
      className: 'message',
    });
    playSound();

    var $list = $('.messages-list');
    if ($list.length) appendMessage($list, data);

    setBadge('messages-link', data.unread);
  }

  /**
   * Append message to the list
   *
   * @param data
   */
  function appendMessage($list, data) {
    if ($list.data('chat-id') != data.object.chat_id) return;

    var item = $(
      '<div class="message received" data-message-id="' + data.object.id + '">' +
        '<div class="msg-content"><p>' + data.object.message + '</p></div>' +
        '<div class="avatar">' +
          '<div class="photo-wrap"><a href="' + data.user.url + '"><img class="photo" src="' + data.user.image + '" width="100%" /></a></div>' +
          '<div class="name"><a href="' + data.user.url + '">' + data.user.full_name + '</a></div>' +
        '</div>' +
      '</div>'
    );

    $list.append(item);

    var $form = $('.message-form');

    $('html, body').animate({
      scrollTop: $form.offset().top + $form.height() - window.innerHeight,
    }, 2000);
  }

  /**
   * Handle NotificationEvent
   *
   * @param data
   */
  function handleNotificationEvent(data) {
    $.notify(data.message, {
      autoHide: true,
      autoHideDelay: 30000,
      className: 'message',
    });
    playSound();

    switch (data.object_type) {
      case 'friends':
        setBadge('friends-link', data.unread);
        break;
    }

    setBadge('notifications-link', data.total);
  }

  /**
   * Set alert badge
   *
   * @param id
   * @param count
   */
  function setBadge(id, count) {
    if (! count) return;
    var $btn = $('#' + id);
    var $badge = $btn.find('.menu-alert');
    if (! $badge.length) {
      $btn.append('<span class="menu-alert">' + count + '</span>')
    } else {
      $badge.text(count);
    }
  }

  /**
   * Play notification sound
   */
  function playSound() {
    var audio = new Audio(app.notification_sound);
    audio.play();
  }

  /**
   * Initialize
   */
  jQuery(function($) {
    // Check fo window.app variable
    if (typeof app === 'undefined' || typeof app.socket === 'undefined') return;
    // Dont initialize if not authenticated
    if (app.socket.token == '') {
      return;
    }

    initWebSockets();
  });

})(jQuery);
