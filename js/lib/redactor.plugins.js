if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.media_free = function () {
    return {
        init: function () {
            var button = this.button.add('media_free', 'Media Element');
            this.button.setAwesome('media_free', 'fa-picture-o');
            this.button.addCallback(button, this.media_free.addMediaTag);
        },
        addMediaTag: function (e) {
            if($('.re-icon.re-media_free').closest('.timeline-block').find('.uploaded').hasClass('loading')){
                alert('Please wait. Image is loading.');
                return false;
            }
            if($('#redactor-toolbar-' + this.uuid).find('.re-icon.re-media_free').hasClass('disabled')) {
                alert('Please select media element');
                return false;
            }

            var stamp = (new Date()).getTime();
            this.block.setData('stamp', stamp);
            var node = this.$editor.find('p[data-stamp='+stamp+']');
            this.block.removeData('stamp');

            if($(node).text().length>0) {
                this.caret.setAfter(node);
            }

            var tag = $('<img/>').attr('src', '/images/media_free.png').addClass('iam_media1');
            var disabled = $('.re-media1').is('.disabled');
            this.$editor.find('.iam_media1').remove();
            this.insert.node(tag);
            this.insert.text(' ');
        }
    };
};



RedactorPlugins.media1 = function () {
    return {
        init: function () {
            var button = this.button.add('media1', 'Media Element #1');
            this.button.setAwesome('media1', 'fa-picture-o');
            this.button.addCallback(button, this.media1.addMediaTag);
        },
        addMediaTag: function (e) {
            if($('.re-icon.re-media1').hasClass('disabled')) {
                alert('Please select media element #1');
                return false;
            }

            var stamp = (new Date()).getTime();
            this.block.setData('stamp', stamp);
            var node = this.$editor.find('p[data-stamp='+stamp+']');
            this.block.removeData('stamp');

            if($(node).text().length>0) {
                this.caret.setAfter(node);
            }

            var tag = $('<img/>').attr('src', '/images/media1.png').addClass('iam_media1');
            var disabled = $('.re-media1').is('.disabled');
            this.$editor.find('.iam_media1').remove();
            this.insert.node(tag);
            this.insert.text(' ');
        }
    };
};

RedactorPlugins.media2 = function () {
    return {
        init: function () {
            var button = this.button.add('media2', 'Media Element #2');
            this.button.setAwesome('media2', 'fa-picture-o');
            this.button.addCallback(button, this.media2.addMediaTag);
        },
        addMediaTag: function () {
            if($('.re-icon.re-media2').hasClass('disabled')) {
                alert('Please select media element #2');
                return false;
            }

            var stamp = (new Date()).getTime();
            this.block.setData('stamp', stamp);
            var node = this.$editor.find('p[data-stamp='+stamp+']');
            this.block.removeData('stamp');

            if($(node).text().length>0) {
                this.caret.setAfter(node);
            }

            var tag = $('<img/>').attr('src', '/images/media2.png').addClass('iam_media2');
            var disabled = $('.re-media2').is('.disabled');
            this.$editor.find('.iam_media2').remove();
            this.insert.node(tag);
            this.insert.text(' ');
        }
    };
};

RedactorPlugins.blockquote = function () {
    return {
        init: function () {
            //changed icons to display them in the same way
            this.button.setAwesome('formatting', 'fa-text-height');
            this.button.setAwesome('bold', 'fa-bold');
            this.button.removeIcon('bold', 'bold');
            this.button.setAwesome('italic', 'fa-italic');
            this.button.removeIcon('italic', 'italic');

            //added margin to icons that havent been replaced
            var link = this.button.get('link');
            $(link).attr('style','margin-top:1px');
            var list = this.button.get('unorderedlist');
            $(list).attr('style','margin-top:1px');


            //var button = this.button.add('blockquote', 'Blockquote');
            //this.button.setAwesome('blockquote', 'fa-quote-left');
            //this.button.addCallback(button, this.blockquote.addBlockquoteTag);
            //this.button.addDropdown(button,this.inline.formatting());
        },
        addBlockquoteTag: function () {
            //this.inline.format('p');
            //this.block.format('blockquote');
        }
    };
};
RedactorPlugins.iconic = function () {
    return {
        init: function () {

            var button = this.button.get('formatting');
            this.button.setAwesome('formatting', 'fa-text-height');
            //this.button.addCallback(button, this.blockquote.addBlockquoteTag);
        }
    };
};