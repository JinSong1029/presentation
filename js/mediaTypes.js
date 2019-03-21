(function ($, root) {

    root.initMediaTypes = function () {

        $(document).on('change', 'select.icc-media-element_select', function (e) {

            var $this = $(this);

            var detach_id = $this.parent().siblings('.icc-media-element_content').data('detach-id');

            var type = $this.val();
            var name = $this.attr('name').replace('[type]', '');

            var $content = $this.parent().siblings('.icc-media-element_content');

            $this.parent().siblings('.icc-media-element_library').addClass('show');
            $this.parent().siblings('.icc-media-element_remove').addClass('show');

            if( $content.length == 0) {
                $content = $('<div class="icc-media-element_content"/>');
                $content.data('name', name);
                $this.parent().after($content);
            }

            $content.html( $('#media-element-template').find('.media-'+type).html() );

            $content.find('input, select, textarea').each(function (i, el) {
                if( $(el).attr('name') != "tempFile" ) {
                    $(el).attr('name', name + $(el).attr('name'));
                }
            });

            $content.find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);

            if(detach_id) {
                //console.log(111, detach_id);
                $content.append('<input type="hidden" name="'+name+'[mediaToDetach]" value="'+detach_id+'" />');
            }

        });


        $(document).on('click', '.icc-media-element_library', function () {
            return false;
        });

        $(document).on('click', '.icc-media-element_remove', function () {
            var $this = $(this);

            var detach_id = $this.parent().find('.icc-media-element_content').data('detach-id');
            var name = $this.parent().find('.icc-media-element_select select').attr('name').replace('[type]', '');

            var $content = $this.parent().find('.icc-media-element_content');
            $content.html( detach_id ? '<input type="hidden" name="'+name+'[mediaToDetach]" value="'+detach_id+'" />' : "" );

            $this.parent().find('.icc-media-element_library').removeClass('show');
            $this.parent().find('.icc-media-element_remove').removeClass('show');

            var $selector_with_type = $this.parent().find('select.icc-media-element_select');

            var $default_value = $selector_with_type.find("option[value='']");
            if(!$default_value.text()){
                $selector_with_type.prepend( $('<option value="">Media type...</option>').prop("selected", "selected"));
            } else {
                $default_value.prop("selected", "selected");
            }

            return false;
        });

        $(document).on('click', '.icc-media-element_order .fa, .icc-carousel-slide-order .fa', function () {
            if(!$(this).hasClass('active')) {
                return false;
            }
        });

        $(document).on('click', '.icc-media-element_order .fa-chevron-down.active', function () {
            var _this = this;
            $(_this).closest('.icc-media-elements').addClass('icc-flash');
            setTimeout(function() {
                swapMediaBlocks.call(_this, 1);
                refreshOrderArrows();
                setTimeout(function() {
                    $(_this).closest('.icc-media-elements').removeClass('icc-flash');
                }, 420);
            }, 200);

            var media_reversed = $('#media_reversed').val();
            media_reversed = (media_reversed == 0) ? 1 : 0;
            $('#media_reversed').val(media_reversed);

            return false;
        });

        $(document).on('click', '.icc-media-element_order .fa-chevron-up.active', function () {
            var _this = this;
            $(_this).closest('.icc-media-elements').addClass('icc-flash');
            setTimeout(function() {
                swapMediaBlocks.call(_this, -1);
                refreshOrderArrows();
                setTimeout(function() {
                    $(_this).closest('.icc-media-elements').removeClass('icc-flash');
                }, 420);
            }, 200);

            var media_reversed = $('#media_reversed').val();
            media_reversed = (media_reversed == 0) ? 1 : 0;
            $('#media_reversed').val(media_reversed);

            return false;
        });


        $(document).on('click', '.icc_carousel-add-button', function () {
            var $parent = $(this).parents('.icc-media-element_content');
            var name = $parent.data('name');
            var $target = $parent.find('.icc_carousel-slides');
            var count = $target.data('count');
            var $template = $('#media_carousel-slide-template').clone();
            $template.find('input, select, textarea').each(function (i, el) {
                if( $(el).attr('name') != "tempFile" ) {
                    var suffix = $(el).attr('name').replace('[0]', '[' + count + ']');
                    $(el).attr('name', name + suffix);
                }
            }).html();
            $target.append( $template.html() );
            $target.find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
            $target.data('count', count+1);
            return false;
        });

        $(document).on('click', '.icc-carousel-slide-order .fa-chevron-down', function () {
            var _this = this;
            $(_this).closest('.icc-carousel-single-slide').addClass('icc-flash');
            setTimeout(function() {
                swapCarouselSlides.call(_this, 1);
                setTimeout(function() {
                    $(_this).closest('.icc-carousel-single-slide').removeClass('icc-flash');
                }, 20);
            }, 100);
            return false;
        });

        $(document).on('click', '.icc-carousel-slide-order .fa-chevron-up', function () {
            var _this = this;
            $(_this).closest('.icc-carousel-single-slide').addClass('icc-flash');
            setTimeout(function() {
                swapCarouselSlides.call(_this, -1);
                setTimeout(function() {
                    $(_this).closest('.icc-carousel-single-slide').removeClass('icc-flash');
                }, 20);
            }, 100);
            return false;
        });

        $(document).ready(function(){
            if($('#media_reversed').val() == 1){
                var _this = $('#media_first');
                $(_this).closest('.icc-media-elements').addClass('icc-flash');
                setTimeout(function() {
                    swapMediaBlocks.call(_this, 1);
                    refreshOrderArrows();
                    setTimeout(function() {
                        $(_this).closest('.icc-media-elements').removeClass('icc-flash');
                    }, 420);
                }, 200);
            }

            $('.icc-media-elements').each(function (){
                if($(this).find('.icc-media-element_select select').val() != 0){
                    $(this).find('.icc-media-element_library').addClass('show');
                    $(this).find('.icc-media-element_remove').addClass('show');
                }
            });
        });

        function swapCarouselSlides (position) {
            var $current= $(this).parents('.icc-carousel-single-slide');
            if(position > 0) {
                $current.next().after($current);
            } else {
                $current.prev().before($current);
            }

            var $parent = $current.parents('.icc_carousel-slides');

            $parent.find('.icc-carousel-single-slide').each(function (i, el) {
                var index = $(el).index();
                $(el).find('select, input, textarea').each(function (i, el) {
                    var new_name = $(el).attr('name').replace(/\[image\]\[[0-9]\]/g, "[image]["+index+"]");
                    //console.log(index, $(el).attr('name'), new_name);
                    $(el).attr('name', new_name);
                });
            });
        }


        function swapMediaBlocks (position) {
            var $current= $(this).parents('.icc-media-elements');
            if(position > 0) {
                $current.next().after($current);
            } else {
                $current.prev().before($current);
            }
        }

        function refreshOrderArrows () {
            var $mediaElements = $('.icc-media-wrapper').find('.icc-media-elements:visible');
            var count = $mediaElements.length;

            //console.log($mediaElements);
            $mediaElements.each(function (i, el) {
                var index = $(el).index()-1;

                $(el).find('select, input, textarea').each(function (i, el) {
                    var new_name = $(el).attr('name').replace(/elements\[[0-9]\]/g, "elements["+index+"]");
                    //console.log(index, $(el).attr('name'), new_name);
                    $(el).attr('name', new_name);
                });

                if( index === 0 ) {
                    $(el).find('.fa-chevron-down').addClass('active');
                    $(el).find('.fa-chevron-up').removeClass('active');
                } else if ( index === (count-1) ) {
                    $(el).find('.fa-chevron-down').removeClass('active');
                    $(el).find('.fa-chevron-up').addClass('active');
                } else {
                    $(el).find('.fa-chevron-down').addClass('active');
                    $(el).find('.fa-chevron-up').removeClass('active');
                }
            });
        }

    }


})(jQuery, main);