jQuery(function($) {

    $('.datepicker').datepicker({
        maxDate: "+1m +1d +1y",
        dateFormat: 'mm/dd/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
    });

    $(".fancybox").fancybox();

    $('.select2').select2();

    initPostImageUpload();

});

var loadFile = function(event) {
    var output = document.getElementById('profile-output');
    output.src = URL.createObjectURL(event.target.files[0]);
};

/**
 * Post image uploading
 */
function initPostImageUpload() {
    var $btn = $('#pf-btn-image');
    var $input = $('#pf-image-input');
    var $box = $('#pf-image-box');

    $btn.click(function(e) {
        e.preventDefault();
        $input.click();
    });

    $input.on('change', function(e) {
        var url = URL.createObjectURL(e.target.files[0]);
        $box.empty();
        $('<img>').attr({src: url})
            .wrap('<div />')
            .parent().appendTo($box);
    });

    $box.on('click', 'div', function(e) {
        $(this).remove();
        $input.val('');
        $box.append($('<input>').attr({type: 'hidden', name: 'remove_image', value: 'true'}));
    });
}
