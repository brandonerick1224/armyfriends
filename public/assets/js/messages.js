(function ($) {
    "use strict";

    var $holder;

    /**
     * Add single message
     */
    function addMessage(message) {
        var content = $('<div class="msg-content"><p>' + message.message + '</p></div>');
        var avatar = $(
            '<div class="avatar">' +
                '<div class="photo-wrap"><a href="' + message.user_link + '"><img class="photo" src="' + message.user_image + '" width="100%" /></a></div>' +
                '<div class="name"><a href="' + message.user_link + '">' + message.user_name + '</a></div>' +
            '</div>'
        );

        var continer = $('<div class="message ' + message.direction + '" data-message-id="' + message.id + '">');

        continer.append(avatar);
        if (message.direction == 'sent') {
            continer.append(content);
        } else {
            continer.prepend(content);
        }

        $holder.append(continer);
    }

    /**
     * Add messages
     */
    function addMessages(messages) {
        $.each(messages, function(i, message) {
           addMessage(message);
        });

        $holder.data('last-id', messages[messages.length - 1].id);
    }

    /**
     * Notify user
     */
    function notify() {
        playSound();

        var $form = $('.message-form');

        $('html, body').animate({
            scrollTop: $form.offset().top + $form.height() - window.innerHeight,
        }, 2000);
    }

    /**
     * Play notification sound
     */
    function playSound() {
        var audio = new Audio(varsMessages.sound);
        audio.play();
    }

    /**
     * Check for new messages
     */
    function checkNewMessages() {
        $.ajax({
            url: varsMessages.url,
            data: {chat_id: $holder.data('chat-id'), last_id: $holder.data('last-id')},
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.length) {
                    addMessages(data);
                    notify();
                }
            }
        });
    }

    /**
     * Initialize
     */
    jQuery(function($) {

        if (typeof varsMessages === 'undefined') return;
        $holder = $('.messages-holder');
        if (! $holder.length) return;

        setInterval(function() {
            checkNewMessages();
        }, 10000);

    });

})(jQuery);
