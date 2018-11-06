
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./userPhoto');

$('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
});