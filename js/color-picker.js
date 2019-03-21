$(document).ready(function () {

    //everything fails if there's no el on page
    if(!document.querySelector('#overlay_color_box')){
        return;
    }

    var parentBasic = document.querySelector('#overlay_color_box'),
        popupBasic = new Picker({
            parent: parentBasic,
            color: $('#txtOverlayColor').val()=="" || $('#txtOverlayColor').val().indexOf('rgb')==-1? "#00464c" : $('#txtOverlayColor').val()
        });
    parentBasic.style.backgroundColor = $('#txtOverlayColor').val()=="" || $('#txtOverlayColor').val().indexOf('rgb')==-1? "#00464c" : $('#txtOverlayColor').val();
    popupBasic.onChange = function(color) {
        parentBasic.style.backgroundColor = color.rgbaString;
        $('#txtOverlayColor').val(color.rgbaString);
    };
    popupBasic.openHandler();
});