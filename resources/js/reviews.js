$('[data-target="#add-review"]').click(function () {
    var $modal = $('#add-review');
    var $place = $(this).closest('.row');
    $modal.find('#name').text($place.find('.name').text());
    $modal.find('#address').text($place.find('.address').text());
    $modal.find('#id').val($place.find('.id').text());
});