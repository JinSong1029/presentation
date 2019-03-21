$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function updateSectionPositions() {
    var positions = {};
    $(this.el).find('.morris-presentation-block').each(function (i, val) {
        positions[i] = $(val).data('section-id');
    });
    var data = {
        positions: positions
    };


    main.send('/sections/sort', data);
}

function updateSlidePositions() {
    var positions = {};
    $(this.el).find('.morris-presentation-slide').each(function (i, val) {
        var data = $(val).data();
        positions[i] = data.id;
    });
    var data = {
        section_id: $(this.el).data('id'),
        positions: positions
    };

    $(this.el).parents('.morris-section').find('.morris-success-message').stop().fadeIn(100).fadeOut(3500);

    main.send('/slides/sort', data);
}


$(document).ready(function () {

    if (location.href.indexOf("create") !== -1) {

    }

    var slidesList = document.getElementById("presentation-sections");

    if (slidesList) {
        var sort = Sortable.create(slidesList, {
            animation: 200,
            handle: ".move_section", // Restricts sort start click/touch to the specified element
            draggable: ".draggable",
            filter: ".ignore-elements",
            onSort: updateSectionPositions
        });

        $('.morris-presentation-section-slides').each(function () {
            Sortable.create(this, {
                group: 'foo',
                animation: 200,
                //handle: ".move", // Restricts sort start click/touch to the specified element
                draggable: ".morris-presentation-slide",
                onAdd: function () {
                    alert('s');
                },
                onSort: updateSlidePositions
            });
        });
    }


});

/// presentation control buttons and edit form appearance///
$('.edit_presentation').click(function () {
    $('.presentation-edit-form').show();
    $('.presentation-show-title').hide();
});
$('.edit_cancel').click(function () {
    $('.presentation-edit-form').hide();
    $('.presentation-show-title').show();
});

if ($('div').is('.alert')) {
    $('.edit_presentation').click();
}
///// ----- /////


///  section controls and edit form appearance ///

///// CLICK ON CROSS //////
$(document).on('click', '.delete_section a', function (e) {
    $(this).closest('.morris-presentation-block').addClass('confirm-delete');
    $(this).parents('.morris-presentation-block').find('.morris-section-delete-confirm').addClass('active');
    e.preventDefault();
});


/// edit section click ////
$(document).on('click', '.edit_section a', function (e) {
    $(this).closest('.morris-presentation-block').addClass('update-name');
    $(this).parents('.morris-presentation-block').find('.morris-section-edit-confirm').addClass('active');
    var name = $(this).parents('.morris-presentation-block').find('.morris-section-title h3');
    var input = $(this).parents('.morris-presentation-block').find('.section-name-input');
    name.hide();
    input.val(name.text());
    input.show();
    e.preventDefault();
});

///remove section click ////
$(document).on('click', '.morris-section-delete-confirm .remove_section', function (e) {
    $(this).parents('#remove-entry-form').submit();
    $(this).parents('.morris-section-delete-confirm').removeClass('active');

    e.preventDefault();
});

//// update section name /////
$(document).on('click', '.morris-section-edit-confirm .update_section', function (e) {
    var name = $(this).parents('.morris-presentation-block').find('.section-name-input');
    var title = $(this).parents('.morris-presentation-block').find('.morris-section-title h3');
    var id = $(this).data('section_id');

    $.ajax({
        type: "POST",
        url: "/sections/" + id,
        data: "_method=PUT&name=" + name.val(),
        cache: false,
        success: function (data) {
            title.text(name.val());
            title.show();
            name.hide();
        }
    });
    //$(this).parents('#update-entry-form').submit();

    $(this).parents('.morris-section').find('.morris-success-message').stop().fadeIn(100).fadeOut(3500);

    $(this).parents('.morris-section-edit-confirm').removeClass('active');
    e.preventDefault();
});

//// Choose slide color /////
$('.chooseColor').on('click', function () {
    $.ajax({
        type: "POST",
        url: "/slides/" + $(this).data('slide') + '/changeColor',
        data: "color=" + $(this).val(),
        cache: false,
        success: function (data) {
        }
    });
});

//// Choose slide color /////
$('.chooseImagesTemplete').on('change', function () {
    console.log($(this).val());
    $('.templete-3').toggleClass('hidden');
    $('.templete-4').toggleClass('hidden');
    if ( $('.templete-3').hasClass('hidden') ) {
        $('.templete-3 input[type=file]').attr('name', 'text3');
        $('.templete-3 input[type=hidden]').attr('name', 'image3');
    } else {
        $('.templete-3 input[type=file]').attr('name', 'image3');
        $('.templete-3 input[type=hidden]').attr('name', 'text3');
    }
    if ( $('.templete-4').hasClass('hidden') ) {
        $('.templete-4 input[type=file]').attr('name', 'text4');
        $('.templete-4 input[type=hidden]').attr('name', 'image4');
    } else {
        $('.templete-4 input[type=file]').attr('name', 'image4');
        $('.templete-4 input[type=hidden]').attr('name', 'text4');
    }
});

///// CLICK CANCEL WHEN EDIT ////////
$(document).on('click', '.morris-section-delete-confirm .edit_cancel', function (e) {
    $(this).parents('.morris-section-delete-confirm').removeClass('active');
    $(this).closest('.morris-presentation-block').removeClass('confirm-delete');
    e.preventDefault();
});
$(document).on('click', '.morris-section-edit-confirm .edit_cancel', function (e) {
    $(this).parents('.morris-section-edit-confirm').removeClass('active');
    $(this).closest('.morris-presentation-block').removeClass('update-name');
    var name = $(this).parents('.morris-presentation-block').find('.section-name-input');
    var title = $(this).parents('.morris-presentation-block').find('.morris-section-title h3');
    title.show();
    name.hide();
    e.preventDefault();
});

$(document).on('click', '.morris-presentation-add-section .add_section', function (e) {

    var name = $(this).parents('.morris-presentation-add-section').find('input[name="newSection"]');
    var presentation = $(this).data('presentation');
    var position = $('input[name="sectionsCount"]').val();

    $.ajax({
        type: "POST",
        url: "/sections",
        data: "name=" + name.val() + "&position=" + (parseInt(position) + 1) + "&presentation_id=" + presentation,
        cache: false,
        success: function (data) {
            location.reload();
//TODO add section markup
        }
    });
    e.preventDefault();
});


// SHOW ADD SLIDE BLOCK
$(document).on('click', '.morris-presentation-slide-add', function (e) {
    e.preventDefault();
    var
        $this = $(this),
        container = $this.parents('.morris-presentation-block'),
        addSlideField = container.find('.morris-section-addslide');
    firstInput = addSlideField.find('.form-group').first().find('input');

    if (addSlideField.css('display') === 'none') {

        container.addClass('add-slide-mode');
        addSlideField.stop(true, true).slideDown(300);
        firstInput.focus();

    } else {

        container.removeClass('add-slide-mode');
        addSlideField.stop(true, true).slideUp(300);
        $this.blur();

    }
});

$(document).on('click', '.morris-presentation-slide-move-cancel', function (e) {
    e.preventDefault();
    $(this).parents('.morris-section-moveslide').stop(true, true).slideUp(300);
});

$(document).on('submit', '.morris-move-slide-form', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var $this = $(this);
    $.ajax({
        type: $this.attr('method'),
        url: $this.attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            var slidesSection = $(".morris-presentation-section-slides[data-id='" + data.section + "']");
            var slideId = $this.data('slide');
            var slide = $(".morris-presentation-slide[data-id='" + slideId + "']");

            console.log(slide.html());
            console.log('slide is ' + slideId);

            if (data.hideAddBlock) {
                $('.singular').hide();
            }
            if (data.appendAddBlock) {
                $('.singular').show();
                $('.singular-no-more').val('0');
            }

            slide.find('.morris-presentation-slide-moveToSection').toggleClass('expanded');
            slide.data('position', data.position);
            var clone = slide.clone();
            slide.remove();
            slidesSection.append(clone);

            var container = $this.parents('.morris-presentation-block');
            container.removeClass('add-slide-mode');

            //drop select value and slide it up
            container.find('.morris-section-moveslide').stop(true, true).slideUp(300);
            $('.moveToSectionSelect').val(0);
        },
        error: function (data) {
            var message = eval('(' + data.responseText + ')').message;

            var errBl = $this.parents('.morris-section').find('.morris-error-message');
            errBl.html(message);
            errBl.stop().fadeIn(100).fadeOut(3500);
        }
    });
});

$(document).on('click', '.morris-presentation-slide-moveToSection', function (e) {
    e.preventDefault();
    var
        $this = $(this),
        container = $this.parents('.morris-presentation-block'),
        moveSlide = container.find('.morris-section-moveslide'),
        form = moveSlide.find('.morris-move-slide-form').first();

    form.attr("action", '/slides/' + $this.data('slideid') + '/move');
    form.data('slide', $this.data('slideid'));

    $('.morris-presentation-slide-moveToSection').not(this).removeClass('expanded');
    $this.toggleClass('expanded');

    if ($this.hasClass('expanded')) {

        container.addClass('add-slide-mode');
        moveSlide.stop(true, true).slideDown(300);

    } else {

        container.removeClass('add-slide-mode');
        moveSlide.stop(true, true).slideUp(300);

    }

});

// HIDE ADD SLIDE BLOCK
$(document).on('click', '.morris-presentation-slide-add-cancel', function (e) {
    var
        $this = $(this),
        container = $this.parents('.morris-presentation-block'),
        $block = container.find('.morris-section-addslide');
    $block.slideUp(300);
    container.removeClass('add-slide-mode');
    $('#validation-errors').html('');
    e.preventDefault();
});

///  SET ACTIVE PRESENTATION /////
$('.check-row-action a').click(function (e) {
    var row = $(this).parents('tr');

    var presentation = row.data('presentation');
    var hidden = 0;
    if (row.hasClass('presentation-active')) {
        active = 0;
        row.removeClass('presentation-active');
    }
    else {
        active = 1;
        $('.presentation-active').removeClass('presentation-active');
        row.addClass('presentation-active');
    }

    $.ajax({
        type: "POST",
        url: "/presentations/" + presentation + "/setActive",
        data: "active=" + active,
        cache: false,
        success: function (data) {
        }
    });
});

//// SET PRESENTATION ARCHIVED /////
$('.lock-row-action a').click(function (e) {
    var presentation = $(this).parents('tr').data('presentation');
    var hide = $(this).find('i');
    var archived = 0;

    if (hide.hasClass('fa-unlock-alt')) {
        archived = 1;
    }

    $(this).parents('tr').remove();
    $.ajax({
        type: "POST",
        url: "/presentations/" + presentation + "/setArchived",
        data: "archived=" + archived,
        cache: false,
        success: function (data) {
        }
    });
});

//add placeholder slide
//$('.morris-create-slide-form select').on('change', function (e) {
//    if ($(this).val() === 'heading') {
//        $('.morris-create-slide-form input[name="name"]').val('Heading');
//    }
//});

//remove slide
var confirmDeleteSlide = (function () {
    function _setUpListeners() {
        $(document).on('click', '.morris-presentation-slide-icons .remove', _showConfirm);
        $(document).on('click', '.morris-slide-delete-confirm .remove_slide', _confirmRemove);
        $(document).on('click', '.morris-slide-delete-confirm .edit_cancel', _cancelRemove);
    }

    function _showConfirm(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-presentation-block'),
            confirm = container.find('.morris-slide-delete-confirm'),
            slide = $this.closest('.morris-presentation-slide'),
            slideId = slide.data('id'),
            removeBtn = confirm.find('.remove_slide');

        if (!confirm.hasClass('active')) {
            confirm.addClass('active');
            removeBtn.data('id', slideId);
            slide.addClass('selected');
        }
    }


    function _confirmRemove(e) {
        e.preventDefault();

        var
            $this = $(this),
            slideId = $this.data('id'),
            confirm = $this.closest('.morris-slide-delete-confirm'),
            container = $this.closest('.morris-presentation-block'),
            slide = container.find('.morris-presentation-slide.selected'),
            section = slide.data('section');
        console.log('section - ' + section);

        if (section == 1) {
            console.log('yes it\'s one');
            $('.morris-presentation-slide.singular').show();
            $('#intro_singular').val(0);
        }


        $.get('/slides/' + slideId + '/delete');
        slide.remove();
        confirm.removeClass('active');
        $this.data('id', '');
    }

    function _cancelRemove(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-presentation-block'),
            confirm = container.find('.morris-slide-delete-confirm'),
            slide = container.find('.morris-presentation-slide.selected'),
            removeBtn = confirm.find('.remove_section');

        confirm.removeClass('active');
        slide.removeClass('selected');
        removeBtn.data('id', '');
    }

    return {
        init: _setUpListeners
    };
}());
confirmDeleteSlide.init();

//// REFRESH KEYS //////
$('.refresh-row-action a').click(function (e) {
    var id = $(this).data('presentation');
    $('#random_refresh' + id).submit();
});

$('.morris-ajax-form').on('submit', function (e) {
    var formData = new FormData(this);
    // console.log($(this).attr('action'));
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            $('#validation-errors').html('');

            if (window.morrisRedirect && morrisRedirect != "return") {
                if (window.morrisRedirect === 'newPresentation') {
                    console.log('redirect');
                    window.location.href = location.protocol + '//' + location.host + "/presentations/" + data.presentation + "/edit";
                } else {
                    window.location.href = location.protocol + '//' + location.host + location.pathname;
                }
            }
            else {
                window.location.href = location.protocol + '//' + location.host + "/presentations/" + $('#meta').data('presentation-id') + "/edit";
            }
            if (window.morrisRedirect && morrisRedirect == "preview") {
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?preview=1';
            }

        },
        error: function (errors) {
            console.warn();
            var err = eval('(' + errors.responseText + ')');
            var dump = "";
            $.each(err, function (i, val) {
                dump += '<div class="alert alert-warning">' + val[0] + '</div>';
            });
            $('#validation-errors').html(dump);

        }
    });
    e.preventDefault();
});


$('.morris-create-slide-form').on('submit', function (e) {
    var $this = $(this);
    var block_time = 1000;

    var currentSlide = $this.find('input[name="slidesCount"]').attr('value');
    console.log(parseInt(currentSlide) + 1);
    if (!$this.hasClass('disabled')) {
        var button = $this.find('div.subm > input');
        if (button.hasClass('clicked'))
            return false;

        button.addClass('clicked');

        $this.addClass('disabled');
        unblock = function () {
            $this.removeClass('disabled');
        }
        setTimeout(unblock, block_time);

        var $section = $this.parents('.morris-section');
        var $slides = $section.find('.morris-presentation-section-slides');
        var formData = new FormData(this);
        var index = $slides.find('.morris-presentation-slide').length;
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $this.find('.validation-errors-slide').html('');
                console.log('type - ' + data.type);
                var edit = data.type === 'placeholder' ? '' : '<a class="edit" href="/presentations/' + $slides.data('presentation-id') + '/slides/' + data.id + '/edit"><i class="fa fa-pencil"></i></a> ';
                button.removeClass('clicked');

                if ($this.find('input[name="singular"]').length) {
                    $('.morris-presentation-slide.singular').hide();
                }
                var html = '<div class="morris-presentation-slide" data-position="' + index + '" data-id="' + data.id + '" data-section="' + $slides.data('order') + '">' +
                    '<small>' + data.type + '</small><br/>' + data.name + '<div class="morris-presentation-slide-icons">' +
                    edit +
                    '<a class="move" href="#"><i class="fa fa-arrows"></i></a> ' +
                    '<a data-slideId="'+data.id+'" class="morris-presentation-slide-moveToSection"><i class="fa fa-folder"></i></a> ' +
                    '<a class="remove" href="/slides/' + data.id + '/delete"><i class="fa fa-times"></i></a></div>';

                $slides.append(html);

                $this[0].reset();
                $this.parents('.morris-section-addslide').slideUp(200);

                $section.find('.morris-success-message').stop().fadeIn(100).fadeOut(3500);
            },
            error: function (errors) {
                button.removeClass('clicked');
                console.warn();
                var err = eval('(' + errors.responseText + ')');
                var dump = "";
                $.each(err, function (i, val) {
                    dump += '<div class="alert alert-warning">' + val[0] + '</div>';
                });
                $this.find('.validation-errors-slide').html(dump);
            }
        });
        e.preventDefault();
    }
    return false;
});


$(document).on('click', '.morris-ajax-form-submit', function () {
    window.morrisRedirect = $(this).attr('name') ? $(this).attr('name') : $(this).data('action');
    if (window.morrisRedirect == 'preview' || window.morrisRedirect == 'submit_multiple') {
        $('.submit-subslide').submit();
    }

});

$(document).on('click', '.morris-presentation-slide-tombstone .remove', function () {
    var
        $this = $(this),
        slide = $this.closest('.morris-presentation-slide-tombstone'),
        form = $('.morris-presentation-slide-title .morris-delete-confirm-form'),
        imageId = $this.closest('.morris-presentation-slide-tombstone').data('id');
        imageIdInput = form.find('.image-id-holder');

    if (!form.hasClass('active')) {
        imageIdInput.val(imageId);
        form.slideDown(500).addClass('active');
        slide.addClass('selected');
    }
});


$(document).on('click', '.morris-presentation-slide-quote .remove', function () {
    var
        $this = $(this),
        slide = $this.closest('.morris-presentation-slide-quote'),
        form = $('.morris-presentation-slide-title .morris-delete-confirm-form'),
        imageId = $this.closest('.morris-presentation-slide-quote').data('id');
    imageIdInput = form.find('.image-id-holder');

    if (!form.hasClass('active')) {
        imageIdInput.val(imageId);
        form.slideDown(500).addClass('active');
        slide.addClass('selected');
    }
});


$(document).on('click', '.morris-slide-delete-confirm-form .cancel', function () {
    var
        $this = $(this),
        form = $this.parents('.morris-slide-delete-confirm-form'),
        slide = $('.morris-presentation-slide-tombstone.selected');

    form.slideUp(500).removeClass('active');
    slide.removeClass('selected');
});


$(document).on('click', '.morris-delete-confirm-form .cancel', function () {
    console.log(111)
    var
        $this = $(this),
        form = $this.parents('.morris-delete-confirm-form'),
        slide = $('.morris-presentation-slide-tombstone.selected');

    form.slideUp(500).removeClass('active');
    slide.removeClass('selected');
});

$(document).on('click', '.morris-presentation-slide-remove .remove-confirmed', function () {
    var $el = $(this).parents('.morris-presentation-slide-remove');
    $el.removeClass('remove-confirm');
    return false;
});

//duplicate presentation (current presentation page)
$('.duplicate-row-action a').on('click', function (e) {
    e.preventDefault();

    var
        $this = $(this),
        container = $this.parents('tr'),
        form = container.find('form');

    form.submit();
});
$(document).ready(function () {
    radioChecker();
    function radioChecker() {
        var
            checkRadio = $('.procedure-control input[name="type"]:checked').val();

        $('.procedure-label, .procedure-desc, .procedure-image').removeClass('selected');

        if (checkRadio === 'quote' || checkRadio === 'text') {
            $('.procedure-label, .procedure-desc').addClass('selected');
        } else if (checkRadio === 'image') {
            $('.procedure-image').addClass('selected');
        }
    }

    $('.procedure-control input[name="type"]').on('change', function () {
        radioChecker();
    });

    if ($('.procedure-control input[name="type"]:checked').length == 0) {
        $('.procedure-control input[name="type"]:first').click();
    }
    if ($('.procedure-control input[name="double"]:checked').length == 0) {

        $('.procedure-control input[name="double"]:first').click();
        $('.procedure-control input[name="double"]:first').addClass('init');
    }
});

var logoEditPageFuntional = (function () {

    function setUpListeners() {
        var
            removeButton = $('.morris-presentation-slide-logo .remove'),
            editButton = $('.morris-presentation-slide-logo .edit'),
            select = $('.morris-presentation-slide-logo .select'),
            imageNameBtn = $('.morris-presentation-slide-logo-name'),
            longDescr = $('.morris-presentation-slide-logo-popup-link');

        removeButton.on('click', _removeImageFromBlock);
        editButton.on('click', _activateEditOptions);


        if (select.length !== 0) {
            select.ready(_ajaxList);
            select.select2({
                templateResult: _selectFormat
            });
        }

        imageNameBtn.on('change', _imageNameChanged);
        select.on('change', _switchImg);
        longDescr.on('click', _descrIndicator);
    }

    //remove logo image from block on edit slides presentation page
    function _removeImageFromBlock(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            fileInput = container.find('input[type="file"]'),
            removeDetector = container.find('input.detached-logo'),
            imageId = container.data('image-id'),
            onchangeDetector = container.parent().find('input.onchange'),
            attachDetector = container.find('input.attached-logo');

        if (container.hasClass('uploaded') || container.hasClass('editing')) {
            container.css('backgroundImage', 'none').removeClass('uploaded').removeClass('editing');
            //reset file input
            fileInput.val('');
            $('.select').find('.select-placeholder').attr('selected', 'selected');
        }
        if (!container.hasClass('choosed-by-select')) {
            if (container.data('type') == 'unselectable') {
                removeDetector.val(1);
            } else {
                removeDetector.val(imageId);
            }
        } else {
            console.log('hasnt');
            container.removeClass('choosed-by-select');
            onchangeDetector.val(false);
        }

        container.removeAttr('data-image-id');
        //for some reason after deleting data removes only from html
        container.data('image-id', null);
        attachDetector.val('');
        _ajaxList();
    }

    function _activateEditOptions(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            select = container.find('.select');
        select.find('options').removeAttr('selected');
        if (container.hasClass('uploaded')) {
            container.removeClass('uploaded').addClass('editing');
        }
    }

    function _imageNameChanged() {
        var
            $this = $(this),
            textInput = $this.siblings('input[type=hidden]');

        textInput.val('true');
    }

    function _ajaxList() {

        var
            images = $('.morris-uploader[data-image-id]'),
            imagesExceptionArr = [];

        $.each(images, function () {
            var
                $this = $(this),
            // imageId = $this.data('image-id');
                imageId = $this[0].dataset.imageId;

            imagesExceptionArr.push(imageId);
        });

        var
            data = {except: imagesExceptionArr},
            url = '/pictures/logos',
            dataType = 'JSON',
            type = 'POST',
            defObj = $.ajax({
                    data: data,
                    type: type,
                    dataType: dataType,
                    url: url
                })
                .done(function (data) {
                    var
                        select = $('.select.form-control'),
                        options = select.find('.select-placeholder');

                    options.siblings().remove();

                    $.each(data, function (index, key) {
                        var
                            markup = "<option value=" + key.name + " data-key=" + key.image + " data-image-id=" + key.id + ">" + key.name + "</option>";

                        select.append(markup);
                    });
                })
                .fail(function (data) {
                    console.log('something wrong');
                });
    }

    function _switchImg(e) {
        var
            $this = $(this),
            sectionWrap = $this.closest('.morris-presentation-slide-logo'),
            changesIndicator = sectionWrap.find('input.onchange'),
            logoWrap = sectionWrap.find('.morris-uploader'),
            imageId = logoWrap.data('image-id'),
            position = logoWrap.data('id'),
            slideId = $('#meta').data('slide-id'),
            selectImageId = $this.find('option:selected').data('image-id'),
            detachImage = logoWrap.find('input.detached-logo'),
            attachImage = logoWrap.find('input.attached-logo'),
            selectedOption = $this.find('option:selected'),
            imgServName = selectedOption.data('key'),
            imgName = selectedOption[0].label,
            nameInput = $this.parent().siblings('.morris-presentation-slide-logo-name');

        //detecting previous picture
        if (imageId) {
            detachImage.val(imageId);
        }
        //choosed by select
        logoWrap.addClass('choosed-by-select');
        //put new pic id in hidden input
        attachImage.val(selectImageId);
        //activating inditator
        changesIndicator.val(true);

        logoWrap.attr('data-image-id', selectImageId);
        logoWrap.css('backgroundImage', "url('/img/images/" + imgServName + "')").addClass('uploaded').removeClass('editing');

        // change title in hidden input
        nameInput.val(imgName);
        _ajaxList();
    }

    function _selectFormat(elem) {
        if (elem.id) {
            var
                $elem = $('<span><img src="/img/images/' + elem.element.dataset.key + '" class="img-logo" /> - ' + elem.text + '<span>');
            return $elem;
        }
    }

    function _descrIndicator() {
        var
            $this = $(this),
            input = $this.parent().find('input.onchange');
        input.val(true);
    }

    return {
        init: setUpListeners
    };
}());

logoEditPageFuntional.init();

var iconEditPageFuntional = (function () {

    function setUpListeners() {
        var
            removeButton = $('.morris-presentation-slide-icon .remove'),
            editButton = $('.morris-presentation-slide-icon .edit'),
            select = $('.morris-presentation-slide-icon .select'),
            imageNameBtn = $('.morris-presentation-slide-icon .morris-presentation-slide-logo-name'),
            longDescr = $('.morris-presentation-slide-icon .morris-presentation-slide-logo-popup-link');

        removeButton.on('click', _removeImageFromBlock);
        editButton.on('click', _activateEditOptions);


        if (select.length !== 0) {
            select.ready(_ajaxList);
            select.select2({
                templateResult: _selectFormat
            });
        }

        imageNameBtn.on('change', _imageNameChanged);
        select.on('change', _switchImg);
        longDescr.on('click', _descrIndicator);
    }

    //remove logo image from block on edit slides presentation page
    function _removeImageFromBlock(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            fileInput = container.find('input[type="file"]'),
            removeDetector = container.find('input.detached-logo'),
            imageId = container.data('image-id'),
            onchangeDetector = container.parent().find('input.onchange'),
            attachDetector = container.find('input.attached-logo');

        if (container.hasClass('uploaded') || container.hasClass('editing')) {
            container.css('backgroundImage', 'none').removeClass('uploaded').removeClass('editing');
            //reset file input
            fileInput.val('');
            $('.select').find('.select-placeholder').attr('selected', 'selected');
        }
        if (!container.hasClass('choosed-by-select')) {
            if (container.data('type') == 'unselectable') {
                removeDetector.val(1);
            } else {
                removeDetector.val(imageId);
            }
        } else {
            console.log('hasnt');
            container.removeClass('choosed-by-select');
            onchangeDetector.val(false);
        }

        container.removeAttr('data-image-id');
        //for some reason after deleting data removes only from html
        container.data('image-id', null);
        attachDetector.val('');
        _ajaxList();
    }

    function _activateEditOptions(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            select = container.find('.select');
        select.find('options').removeAttr('selected');
        if (container.hasClass('uploaded')) {
            container.removeClass('uploaded').addClass('editing');
        }
    }

    function _imageNameChanged() {
        var
            $this = $(this),
            textInput = $this.siblings('input[type=hidden]');

        textInput.val('true');
    }

    function _ajaxList() {

        var
            images = $('.morris-uploader[data-image-id]'),
            imagesExceptionArr = [];

        $.each(images, function () {
            var
                $this = $(this),
            // imageId = $this.data('image-id');
                imageId = $this[0].dataset.imageId;

            imagesExceptionArr.push(imageId);
        });

        var
            data = {except: imagesExceptionArr},
            url = '/pictures/icons',
            dataType = 'JSON',
            type = 'POST',
            defObj = $.ajax({
                    data: data,
                    type: type,
                    dataType: dataType,
                    url: url
                })
                .done(function (data) {
                    var
                        select = $('.select.form-control'),
                        options = select.find('.select-placeholder');

                    options.siblings().remove();

                    $.each(data, function (index, key) {
                        var
                            markup = "<option value=" + key.name + " data-key=" + key.image + " data-image-id=" + key.id + ">" + key.name + "</option>";

                        select.append(markup);
                    });
                })
                .fail(function (data) {
                    console.log('something wrong');
                });
    }

    function _switchImg(e) {
        var
            $this = $(this),
            sectionWrap = $this.closest('.morris-presentation-slide-icon'),
            changesIndicator = sectionWrap.find('input.onchange'),
            logoWrap = sectionWrap.find('.morris-uploader'),
            imageId = logoWrap.data('image-id'),
            position = logoWrap.data('id'),
            slideId = $('#meta').data('slide-id'),
            selectImageId = $this.find('option:selected').data('image-id'),
            detachImage = logoWrap.find('input.detached-logo'),
            attachImage = logoWrap.find('input.attached-logo'),
            selectedOption = $this.find('option:selected'),
            imgServName = selectedOption.data('key'),
            imgName = selectedOption[0].label,
            nameInput = $this.parent().siblings('.morris-presentation-slide-logo-name');

        //detecting previous picture
        if (imageId) {
            detachImage.val(imageId);
        }
        //choosed by select
        logoWrap.addClass('choosed-by-select');
        //put new pic id in hidden input
        attachImage.val(selectImageId);
        //activating inditator
        changesIndicator.val(true);

        logoWrap.attr('data-image-id', selectImageId);
        logoWrap.css('backgroundImage', "url('/img/icons/" + imgServName + "')").addClass('uploaded').removeClass('editing');

        // change title in hidden input
        nameInput.val(imgName);
        _ajaxList();
    }

    function _selectFormat(elem) {
        if (elem.id) {
            var
                $elem = $('<span><img src="/img/icons/' + elem.element.dataset.key + '" class="img-logo" /> - ' + elem.text + '<span>');
            return $elem;
        }
    }

    function _descrIndicator() {
        var
            $this = $(this),
            input = $this.parent().find('input.onchange');
        input.val(true);
    }

    return {
        init: setUpListeners
    };
}());

iconEditPageFuntional.init();

var teamEditPageFuntional = (function () {

    function setUpListeners() {
        var
            removeButton = $('.morris-presentation-slide-team .remove'),
            editButton = $('.morris-presentation-slide-team .edit'),
            select = $('.morris-presentation-slide-team .select'),
            imageNameBtn = $('.morris-presentation-slide-team .morris-presentation-slide-logo-name'),
            longDescr = $('.morris-presentation-slide-team .morris-presentation-slide-logo-popup-link');

        removeButton.on('click', _removeImageFromBlock);
        editButton.on('click', _activateEditOptions);


        if (select.length !== 0) {
            select.ready(_ajaxList);
            select.select2({
                templateResult: _selectFormat
            });
        }

        imageNameBtn.on('change', _imageNameChanged);
        select.on('change', _switchImg);
        longDescr.on('click', _descrIndicator);
    }

    //remove logo image from block on edit slides presentation page
    function _removeImageFromBlock(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            fileInput = container.find('input[type="file"]'),
            removeDetector = container.find('input.detached-logo'),
            imageId = container.data('image-id'),
            onchangeDetector = container.parent().find('input.onchange'),
            attachDetector = container.find('input.attached-logo');

        if (container.hasClass('uploaded') || container.hasClass('editing')) {
            container.css('backgroundImage', 'none').removeClass('uploaded').removeClass('editing');
            //reset file input
            fileInput.val('');
            $('.select').find('.select-placeholder').attr('selected', 'selected');
        }
        if (!container.hasClass('choosed-by-select')) {
            if (container.data('type') == 'unselectable') {
                removeDetector.val(1);
            } else {
                removeDetector.val(imageId);
            }
        } else {
            console.log('hasnt');
            container.removeClass('choosed-by-select');
            onchangeDetector.val(false);
        }

        container.removeAttr('data-image-id');
        //for some reason after deleting data removes only from html
        container.data('image-id', null);
        attachDetector.val('');
        _ajaxList();
    }

    function _activateEditOptions(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            select = container.find('.select');
        select.find('options').removeAttr('selected');
        if (container.hasClass('uploaded')) {
            container.removeClass('uploaded').addClass('editing');
        }
    }

    function _imageNameChanged() {
        var
            $this = $(this),
            textInput = $this.siblings('input[type=hidden]');

        textInput.val('true');
    }

    function _ajaxList() {

        var
            images = $('.morris-uploader[data-image-id]'),
            imagesExceptionArr = [];

        $.each(images, function () {
            var
                $this = $(this),
            // imageId = $this.data('image-id');
                imageId = $this[0].dataset.imageId;

            imagesExceptionArr.push(imageId);
        });

        var
            data = {except: imagesExceptionArr},
            url = '/pictures/teams',
            dataType = 'JSON',
            type = 'POST',
            defObj = $.ajax({
                    data: data,
                    type: type,
                    dataType: dataType,
                    url: url
                })
                .done(function (data) {
                    var
                        select = $('.select.form-control'),
                        options = select.find('.select-placeholder');

                    options.siblings().remove();

                    $.each(data, function (index, key) {
                        var
                            markup = "<option value=" + key.label + " data-key=" + key.image + " data-image-id=" + key.id + ">" + key.label + "</option>";

                        select.append(markup);
                    });
                })
                .fail(function (data) {
                    console.log('something wrong');
                });
    }

    function _switchImg(e) {
        var
            $this = $(this),
            sectionWrap = $this.closest('.morris-presentation-slide-team'),
            changesIndicator = sectionWrap.find('input.onchange'),
            logoWrap = sectionWrap.find('.morris-uploader'),
            imageId = logoWrap.data('image-id'),
            position = logoWrap.data('id'),
            slideId = $('#meta').data('slide-id'),
            selectImageId = $this.find('option:selected').data('image-id'),
            detachImage = logoWrap.find('input.detached-logo'),
            attachImage = logoWrap.find('input.attached-logo'),
            selectedOption = $this.find('option:selected'),
            imgServName = selectedOption.data('key'),
            imgName = selectedOption[0].label,
            nameInput = $this.parent().siblings('.morris-presentation-slide-logo-name');

        //detecting previous picture
        if (imageId) {
            detachImage.val(imageId);
        }
        //choosed by select
        logoWrap.addClass('choosed-by-select');
        //put new pic id in hidden input
        attachImage.val(selectImageId);
        //activating inditator
        changesIndicator.val(true);

        logoWrap.attr('data-image-id', selectImageId);
        logoWrap.css('backgroundImage', "url('/img/teams/" + imgServName + "')").addClass('uploaded').removeClass('editing');

        // change title in hidden input
        nameInput.val(imgName);
        _ajaxList();
    }

    function _selectFormat(elem) {
        if (elem.id) {
            var
                $elem = $('<span><img src="/img/teams/' + elem.element.dataset.key + '" class="img-logo" /> - ' + elem.text + '<span>');
            return $elem;
        }
    }

    function _descrIndicator() {
        var
            $this = $(this),
            input = $this.parent().find('input.onchange');
        input.val(true);
    }

    return {
        init: setUpListeners
    };
}());

teamEditPageFuntional.init();

var tombstoneEditPageFuntional = (function () {

    function setUpListeners() {
        var
            removeButton = $('.morris-presentation-slide-tomb .remove'),
            editButton = $('.morris-presentation-slide-tomb .edit'),
            select = $('.morris-presentation-slide-tomb .select'),
            imageNameBtn = $('.morris-presentation-slide-tomb .morris-presentation-slide-logo-name'),
            longDescr = $('.morris-presentation-slide-tomb .morris-presentation-slide-logo-popup-link');

        removeButton.on('click', _removeImageFromBlock);
        editButton.on('click', _activateEditOptions);


        if (select.length !== 0) {
            select.ready(_ajaxList);
            select.select2({
                templateResult: _selectFormat
            });
        }

        imageNameBtn.on('change', _imageNameChanged);
        select.on('change', _switchImg);
        longDescr.on('click', _descrIndicator);
    }

    //remove logo image from block on edit slides presentation page
    function _removeImageFromBlock(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            fileInput = container.find('input[type="file"]'),
            removeDetector = container.find('input.detached-logo'),
            imageId = container.data('image-id'),
            onchangeDetector = container.parent().find('input.onchange'),
            attachDetector = container.find('input.attached-logo');

        if (container.hasClass('uploaded') || container.hasClass('editing')) {
            container.css('backgroundImage', 'none').removeClass('uploaded').removeClass('editing');
            //reset file input
            fileInput.val('');
            $('.select').find('.select-placeholder').attr('selected', 'selected');
        }
        if (!container.hasClass('choosed-by-select')) {
            if (container.data('type') == 'unselectable') {
                removeDetector.val(1);
            } else {
                removeDetector.val(imageId);
            }
        } else {
            console.log('hasnt');
            container.removeClass('choosed-by-select');
            onchangeDetector.val(false);
        }

        container.removeAttr('data-image-id');
        //for some reason after deleting data removes only from html
        container.data('image-id', null);
        attachDetector.val('');
        _ajaxList();
    }

    function _activateEditOptions(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-uploader'),
            select = container.find('.select');
        select.find('options').removeAttr('selected');
        if (container.hasClass('uploaded')) {
            container.removeClass('uploaded').addClass('editing');
        }
    }

    function _imageNameChanged() {
        var
            $this = $(this),
            textInput = $this.siblings('input[type=hidden]');

        textInput.val('true');
    }

    function _ajaxList() {

        var
            images = $('.morris-uploader[data-image-id]'),
            imagesExceptionArr = [];

        $.each(images, function () {
            var
                $this = $(this),
            // imageId = $this.data('image-id');
                imageId = $this[0].dataset.imageId;

            imagesExceptionArr.push(imageId);
        });

        var
            data = {except: imagesExceptionArr},
            url = '/pictures/tombstones',
            dataType = 'JSON',
            type = 'POST',
            defObj = $.ajax({
                    data: data,
                    type: type,
                    dataType: dataType,
                    url: url
                })
                .done(function (data) {
                    var
                        select = $('.select.form-control'),
                        options = select.find('.select-placeholder');

                    options.siblings().remove();

                    $.each(data, function (index, key) {
                        var
                            markup = "<option value=" + key.label + " data-key=" + key.image + " data-image-id=" + key.id + ">" + key.label + "</option>";

                        select.append(markup);
                    });
                })
                .fail(function (data) {
                    console.log('something wrong');
                });
    }

    function _switchImg(e) {
        var
            $this = $(this),
            sectionWrap = $this.closest('.morris-presentation-slide-tomb'),
            changesIndicator = sectionWrap.find('input.onchange'),
            logoWrap = sectionWrap.find('.morris-uploader'),
            imageId = logoWrap.data('image-id'),
            position = logoWrap.data('id'),
            slideId = $('#meta').data('slide-id'),
            selectImageId = $this.find('option:selected').data('image-id'),
            detachImage = logoWrap.find('input.detached-logo'),
            attachImage = logoWrap.find('input.attached-logo'),
            selectedOption = $this.find('option:selected'),
            imgServName = selectedOption.data('key'),
            imgName = selectedOption[0].label,
            nameInput = $this.parent().siblings('.morris-presentation-slide-logo-name');

        //detecting previous picture
        if (imageId) {
            detachImage.val(imageId);
        }
        //choosed by select
        logoWrap.addClass('choosed-by-select');
        //put new pic id in hidden input
        attachImage.val(selectImageId);
        //activating inditator
        changesIndicator.val(true);

        logoWrap.attr('data-image-id', selectImageId);
        logoWrap.css('backgroundImage', "url('/img/tombstones/" + imgServName + "')").addClass('uploaded').removeClass('editing');

        // change title in hidden input
        nameInput.val(imgName);
        _ajaxList();
    }

    function _selectFormat(elem) {
        if (elem.id) {
            var
                $elem = $('<span><img src="/img/tombstones/' + elem.element.dataset.key + '" class="img-logo" /> - ' + elem.text + '<span>');
            return $elem;
        }
    }

    function _descrIndicator() {
        var
            $this = $(this),
            input = $this.parent().find('input.onchange');
        input.val(true);
    }

    return {
        init: setUpListeners
    };
}());

tombstoneEditPageFuntional.init();

var editSlideName = (function () {

    function setUpListeners() {
        var
            form = $('.morris-presentation-slide-form'),
            buttons = $('.buttons_slide');

        buttons.on('click', _formAction);
        form.on('submit', _updateSlideName);

    }

    function _formAction(e) {
        e.preventDefault();

        var
            $this = $(this),
            container = $this.closest('.morris-presentation-slide-title'),
            form = container.find('.morris-presentation-slide-form'),
            confirmForm = container.find('.morris-presentation-slide-confirm-form'),
            buttonsWrap = container.find('.morris-presentation-slide-redactor'),
            title = container.find('.serif'),
            editButtons = container.find('.buttons_slide');

        if ($this.hasClass('edit_slide')) {

            _releaseForm($this, title, form, buttonsWrap);

        } else if ($this.hasClass('edit_cancel')) {

            _hideForm(form, title, buttonsWrap, editButtons);

        } else if ($this.hasClass('delete_slide')) {
            _showDeleteConfirm(buttonsWrap);
        }
    }

    $('.delete_slide_confirmed').on('click', _deleteSlide);

    function _releaseForm(button, title, form, buttonsWrap) {

        if (!buttonsWrap.hasClass('active')) {
            title.hide();
            form.slideDown(500);
            buttonsWrap.addClass('active');
            button.addClass('tool-active');
        }
    }

    function _hideForm(form, title, buttonsWrap, editButtons) {

        form.slideUp(500, function () {
            title.show();
        });
        buttonsWrap.removeClass('active');
        editButtons.removeClass('tool-active');
    }

    function _updateSlideName(e) {
        e.preventDefault();

        var
            form = $(this),
            formWrap = form.closest('.morris-presentation-slide-title'),
            title = formWrap.find('.serif'),
            slideName = title.text(),
            newSlideName = form.find('input[type=text]').val(),
            slideId = $('#meta').data('slide-id'),
            buttonsWrap = $('.morris-presentation-slide-redactor'),
            buttons = buttonsWrap.find('a');

        if (slideName !== newSlideName) {
            var
                url = '/slides/' + slideId,
                dataType = 'JSON',
                type = 'POST',
                data = '_method=PUT&name=' + newSlideName,
                defObj;

            defObj = $.ajax({
                    data: data,
                    type: type,
                    dataType: dataType,
                    url: url,
                    cache: false
                })
                .always(function () {
                    title.text(newSlideName);
                });
        }

        form.slideUp(500, function () {
            title.show();
        });
        buttonsWrap.removeClass('active');
        buttons.removeClass('tool-active');
    }

    function _showDeleteConfirm(buttonsWrap) {
        $('.morris-slide-delete-confirm-form').slideDown(300);
    }

    function _deleteSlide(buttonsWrap) {
        var
            slideId = $('#meta').data('slide-id'),
            presentationId = $('#meta').data('presentation-id');
        $.get('/slides/' + slideId + '/delete', function () {
            window.location.href = '/presentations/' + presentationId + '/edit';
        });
    }

    return {
        init: setUpListeners
    };
}());
$('.suggest_normal_input').on('click', function (e) {
    var $this = $(this);
    setTimeout(function () {
        if ($this.hasClass('init')) {
            console.log('normal click remove init class');
            $this.removeClass('init')
        } else {
            $('.suggest_normal').toggleClass('hidden');
            $('.suggest_double').toggleClass('hidden');
        }
    }, 500);
});
$('#suggest_double').on('click', function (e) {
    var $this = $(this);
    setTimeout(function () {
        if ($this.hasClass('init')) {
            $this.removeClass('init')
        } else {
            $('.suggest_double').toggleClass('hidden');
            $('.suggest_normal').toggleClass('hidden');
        }
    }, 500);
});
editSlideName.init();