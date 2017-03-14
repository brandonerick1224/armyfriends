/**
 * Image tags plugin
 *
 * @author Vedmant <vedmant@gmail.com>
 */

(function($, window, document, undefined) {
    "use strict";

    var pluginName = 'imageTags';
    var defaults = {
        tags: [],
        debug: true,
        tagUrl: '/tag',
        untagUrl: '/untag',
        usersUrl: '/users',
        canTag: true,
        myUserId: null,
    };

    function Plugin(element, options) {
        this.element = element;
        this.$element = $(element);
        var data_options = parse_data_options(this.$element.data('options'));
        this.options = $.extend({}, defaults, options);
        this.options = $.extend({}, this.options, data_options);
        this._name = pluginName;
        this.init();
    }

    function parse_data_options(data_options_raw) {
        if (data_options_raw === undefined) return [];
        var options = [];
        data_options_raw.split(';').forEach(function(el) {
            var pair = el.split(':');
            if (pair.length == 2) options[pair[0].trim()] = pair[1].trim();
        });
        return options;
    }

    Plugin.prototype = {

        /**
         * Plugin initialization
         *
         * @returns {boolean}
         */
        init: function() {
            var that = this;

            this.$image = this.$element.find('img');
            this.$container = this.$element.wrap('<div class="image-tags-container" />').parent();
            this.$tags = [];

            if (this.options.canTag) {
                this.initTagging();
            }

            this.addTags(this.options.tags);
            this.$image.one('load', function() {
                that.setPositions(that.$tags);
            });

            // On window resize
            $(window).resize(function(e) {
                that.resize();
            });
        },

        /**
         * Init tagging
         */
        initTagging: function() {
            this.$toolContainer = $('<div class="it-toolbar"></div>')
            this.$container.append(this.$toolContainer);

            this.$tagBtn = $('<a href="#" class="it-add-tag btn btn-default btn-sm">Tag people</a>');
            this.$toolContainer.append(this.$tagBtn);

            this.$tagger = $('<a href="#" class="it-tager" style="display: none;"></a>');
            this.$element.append(this.$tagger);

            this.$tagManual = $('<p style="display: none;">Please place red dot on image where you want to tag someone.</p>');
            this.$toolContainer.append(this.$tagManual);

            this.addUserSelect();

            this.bindTagging();
        },

        /**
         * Add user select block
         */
        addUserSelect: function() {
            this.$userSelect = $(
                '<div class="input-group">' +
                    '<select class="it-user-selector form-control select2"></select>' +
                    '<span class="input-group-btn">' +
                        '<button class="it-tag-complete btn btn-default" type="button">Tag!</button>' +
                    '</span>' +
                '</div>'
            );

            this.$toolContainer.append(this.$userSelect);
            this.$userSelect2 = this.$toolContainer.find('.it-user-selector');
            this.$userSelect2.select2({placeholder: 'Select user'});
            this.$userSelect.hide();
            this.$tagCompleteBtn = this.$userSelect.find('.it-tag-complete');
        },

        /**
         * Bind needed actions for tagging
         */
        bindTagging: function() {
            var that = this;
            this.$tagBtn.click(function(e) {
                e.preventDefault();
                that.tag();
            });

            this.$tagger.click(function(e) {
                e.preventDefault();
                that.selectUser();
            });

            this.$tagCompleteBtn.click(function(e) {
                e.preventDefault();
                that.tagComplete();
            });
        },

        /**
         * Tag someone
         */
        tag: function() {
            var that = this;
            this.$tagger.show();
            this.loadUsers(this.$userSelect);
            this.$tagBtn.hide();
            this.$tagManual.show();

            this.$element.on('mousemove', function(e) {
                var $this = $(this);
                var offset = $this.offset();
                var left = e.pageX - offset.left - 10;
                var top = e.pageY - offset.top - 10;

                if (left < 0 || top < 0 || left > ($this.width() - 20) || top > ($this.height() - 20)) return;

                that.$tagger.css({left: left, top: top});
            });
        },

        /**
         * Load users list to select
         */
        loadUsers: function() {
            var that = this;
            $.ajax({
                url: this.options.usersUrl,
                dataType: 'json',
                success: function(res) {
                    that.$userSelect2.select2({data: res});
                },
            })
        },

        /**
         * Select user to tag
         */
        selectUser: function() {
            this.$element.off('mousemove');
            this.$tagManual.hide();
            this.$userSelect.show();
        },

        /**
         * Complete tagging user
         */
        tagComplete: function() {
            var that = this;
            var x = parseInt(this.$tagger.css('left')) / this.$image.width();
            var y = parseInt(this.$tagger.css('top')) / this.$image.height();
            var user_id = this.$userSelect2.val();

            this.$tagCompleteBtn.attr('disabled', 'disabled');

            $.ajax({
                url: this.options.tagUrl,
                dataType: 'json',
                method: 'post',
                data: {x: x, y: y, user_id: user_id},
                success: function(res) {
                    that.$tagCompleteBtn.removeAttr('disabled');

                    if (res.result === 'error') {
                        alert(res.message);
                        return;
                    }

                    that.addTag(res.tag);

                    that.$userSelect.hide();
                    that.$tagger.hide();
                    that.$tagBtn.show();
                },
                error: function(res) {
                    that.$tagCompleteBtn.removeAttr('disabled');
                    alert('Some error occured, please try again, status: ' + res.status);
                },
            });
        },

        /**
         * Untag user
         */
        untag: function(e) {
            var that = this;
            var $btn = $(e.target);
            var $tag = $btn.closest('.it-tag');
            $btn.attr('disabled', 'disabled');

            $.ajax({
                url: this.options.untagUrl + '/' + $tag.data('id'),
                dataType: 'json',
                success: function(res) {
                    $btn.removeAttr('disabled');

                    if (res.result != 'ok') {
                        alert(res.message);
                        return;
                    }


                    $tag.remove();
                    that.$tags = that.$tags.filter(function(el) { return el.data('id') != $tag.data('id'); });
                },
                error: function(res) {
                    $btn.removeAttr('disabled');
                    alert('Some error occured, please try again, status: ' + res.status);
                },
            });
        },

        /**
         * Add tags
         */
        addTags: function(tags) {
            var that = this;
            $.each(tags, function(idx, tag) {
                that.addTag(tag);
            });
        },

        /**
         * Add single tag
         * @param tag
         */
        addTag: function(tag) {
            var that = this;
            var removeTag = '';
            if (this.options.canTag || tag.user_id == this.options.userId) {
                removeTag = '<a href="#" class="itt-untag" title="Untag"></a>';
            }
            var $tag = $(
                '<div class="it-tag" data-id="' + tag.id + '">' +
                    '<div class="itt-indicator"></div>' +
                    removeTag +
                    '<div class="itt-content">' +
                        '<div class="itt-content-inner">' +
                            '<div class="itt-image"><a href="' + tag.link + '"><img src="' + tag.image + '" alt=""></a></div>' +
                            '<div class="itt-title"><a href="' + tag.link + '">' + tag.title + '</a></div>' +
                        '</div>' +
                    '</div>' +
                '</div>');
            $tag.data(tag);
            this.$container.append($tag);
            this.$tags.push($tag);
            this.setPosition($tag);

            $tag.find('.itt-untag').click(function(e) {
                e.preventDefault();
                that.untag(e);
            });
        },

        /**
         * Set tags positions
         */
        setPositions: function($tags) {
            var that = this;
            $.each($tags, function(idx, $tag) {
                that.setPosition($tag);
            });
        },

        /**
         * Set single tag position
         * @param $tag
         */
        setPosition: function($tag) {
            var left = this.$image.width() * $tag.data('x');
            var top = this.$image.height() * $tag.data('y');
            $tag.css({left: left, top: top});
        },

        /**
         * On window resize
         */
        resize: function() {
            this.setPositions(this.$tags);
        },


    }; // Plugin.prototype

    $.fn[pluginName] = function(options) {
        var args = [].slice.call(arguments, 1);
        return this.each(function() {
            if (! $.data(this, 'plugin_' + pluginName))
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            else if ($.isFunction(Plugin.prototype[options]))
                $.data(this, 'plugin_' + pluginName)[options].apply($.data(this, 'plugin_' + pluginName), args);
        });
    }

})(jQuery, window, document);
