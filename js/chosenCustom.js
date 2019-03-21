(function ($, root) {

    root.initTopicsAndCategories = function () {

        var chosenChange = function (e) {
            var $this = $(e.target);
            var current = $this.val();
            var checked = $this.data('checked-values') ? $this.data('checked-values').split(',') : [];
            var label = $this.find(':selected').text();

            if (label.search("All topics") !== -1) {
                checked = [current];
                $this.data('checked-values', checked.join(','));
                $this.data('single-choise', 1);

            } else if (current.length > 0 && checked.indexOf(current) === -1) {

                if(label.search("Partner bulletin") !== -1) {
                    var $access = $('.icc-story-access-select select');
                    if( $access.val() == "firmwide" ) {
                        $access.find('option[value="firmwide"]').attr('disabled', 'disabled');
                        $access.val('directors').trigger('change', {noRefresh: true});
                    }
                    var $story = $('#story-select');
                    $story.attr('disabled', 'disabled');
                }

                if($this.data('single-choise') == 1) {
                    checked = [];
                    $this.data('single-choise', 0);
                }
                checked.push(current);
                
                // If all topics are used then they are replaced with 'All topics'
                if($this.hasClass('icc-topics-select')) {
                    var $options = $this.find('option');
                    var optCount = $options.length;
                    var alltopics = $.grep($options, function (val) {
                        return $(val).text() == "All topics"
                    });
                    alltopics = $(alltopics).val();
                    if (checked.length >= optCount-2) {
                        $this.val(alltopics).change();
                        return;
                    }
                }
                $this.data('checked-values', checked.join(','));
            }

            var dump = '';
            $.each($this.find('option'), function (i, val) {
                if (checked.indexOf(val.value) !== -1) {
                    dump += '<a href="#" class="chosen-remove-selected" data-id="' + val.value + '"><i class="fa fa-times-circle' +
                    '"></i> ' + $(val).text() + '</a><br/>';
                }
            });
            $this.siblings('.selected-values').html(dump);
            $this.val('').trigger("chosen:updated");
            $this.siblings('.hidden-input').val(checked.join(','));
        };

        $(document).on('click', '.chosen-remove-selected', function (e) {
            var id = $(this).data('id');

            var bulletin_id = $('.icc-topics-select').find('option:contains("Partner bulletin")').val();

            //if($('.icc-story-access-select select').val() == "directors" && id == bulletin_id) {
            //    return false;
            //}

            if($(this).text().search("Partner bulletin") !== -1) {
                var $access = $('.icc-story-access-select select');
                $access.find('option[value="firmwide"]').removeAttr('disabled', 'disabled');
                $access.val('partners').trigger('change', {noRefresh: true});
                var $story = $('#story-select');
                $story.removeAttr('disabled', 'disabled');
            }

            var $chosen = $(this).parent().siblings('.chosen-select');
            var values = $chosen.data('checked-values') ? $chosen.data('checked-values').split(',') : [];
            values = $.grep(values, function (value) {
                return value != id;
            });
            $chosen.data('checked-values', values.join(','));
            $chosen.change();
            return false;
        });


        $(".chosen-select").each(function (i, el) {
            var inputName = $(el).attr('name');
            $(el).removeAttr('name').prepend("<option></option>");
            var presetValues = $(el).val();

            $(el).removeAttr('multiple').val('')
                .after('<div class="selected-values"></div><input type="hidden" name="'+inputName+'" class="hidden-input">');

            if(presetValues) {
                $(el).siblings('.hidden-input').val(presetValues.join(','));
                $(el).data('checked-values', presetValues.join(','));
            }

            var form = '<div class="icc-chosen-addform">' +
                '<input type="text" name="name" data-type="'+$(el).data('type')+'"/>' +
                '<a class="btn btn-sm btn-link" href="#"><i class="fa fa-plus"></i></a></div>';


            if($(el).is('.icc-topics-select') && $('#story-select').val() == "normal") {
                $(el).find('option:contains("Spotlight")').attr("disabled", "disabled");
                //$(el).find('option:contains("Partner bulletin")').attr("disabled", "disabled");
            }

            if( $(el).is('.icc-categories-select') ) {
                $(el).chosen({
                    disable_search_threshold: 2
                    //allow_single_deselect: true
                }).change(chosenChange).change();
                $(el).siblings('.chosen-container').find('.chosen-drop').append(form);
            } else {
                $(el).chosen({
                    disable_search_threshold: 16
                    //allow_single_deselect: true
                }).change(chosenChange).change();
            }


        });

        $(document).on('click', '.icc-chosen-addform > a', function (e) {
            var $input = $(this).siblings('input');
            var type = $input.data('type');
            var data = {
                name: $input.val(),
                action: "create",
                type: type
            };
            root.send("/admin/tags", data, function (result) {
                $(".chosen-select[data-type='"+type+"']")
                    .append("<option value='"+result.id+"'>"+result.name+"</option>")
                    .trigger("chosen:updated");
                $input.val("");
            });
            e.preventDefault();
        });

    };


})(jQuery, main);