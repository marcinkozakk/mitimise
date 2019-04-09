window.searchUserForMeeting = () => {
    $result = $('#search-result');
    $result.empty();
    $result.append(
        $('<li class="list-group-item text-center">').html(
            '<i class="fas fa-circle-notch fa-2x fa-spin"></i>'
        )
    );
    axios({
        method: 'post',
        url: '/users/search',
        data: {s: $('#s').val()}
    }).then((data) => {
        $result.empty();
        data.data.forEach((user) => {
            var disabled = derived.guests_id.indexOf(user.id) > -1; //user is member already
            $result.append(
                $('<li class="list-group-item list-group-item-action p-2">').append(
                    $('<div class="row no-gutters">').append(
                        $((disabled ? '<span' : '<a') + ' class="col-11" href="#">').html(user.name)
                            .on('click', () => {
                                if(!disabled) addGuest(user.id, user.name, user.photo)
                            }),
                        $('<a class="col-1" href="#">').append('<img href="#" src="' + user.photo + '">')
                    )
                ).addClass(disabled ? 'list-group-item-success': '')
            )
        })
    })
};

var addGuest = (id, name, photo) => {
    $('#s').val('');
    $('#s').focus();
    $('#search-result').empty();
    derived.guests_id.push(id);
    $('.guest-count').html(derived.guests_id.length);

    $('.guest-list').append(
        $('<img data-toggle="tooltip" title="' + name + '" src="' + photo +'" >')
    );
    $('#invite-form').append(
        $('<input type="hidden" name="users_id[]" value="' + id + '">')
    );
    initNewTooltips();
};

$('#locked-modal').modal();