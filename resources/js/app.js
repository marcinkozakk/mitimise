
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./userPhoto');
require('./showCircle');
require('./showMeeting');
require('./map');

$('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
});

if($('.modal .is-invalid').length) {
    $('.modal').has('.is-invalid').modal('show');
}

$(document).mouseup(function (e) {
    var container = $(".popover");

    if (!container.is(e.target)
        && container.has(e.target).length === 0) {
        container.popover("hide");
    }
});

$(function () {
    initNewTooltips();
});

window.initNewTooltips = () => {
    $('[data-toggle="tooltip"]:not([data-original-title])').tooltip();
};