var rotate = (circles) => {
    var deg = 360 / circles;
    $('.avatar-container').each((i, elem) => {
        var startDeg = $(elem).css('--endDeg');
        var endDeg = i * deg;

        $(elem).css({'--endDeg': endDeg + 'deg'});
        $(elem).css({'--startDeg': startDeg});

        $(elem).find('a').css({'--endDeg': -1 * endDeg + 'deg'});
        $(elem).find('a').css({'--startDeg': '-' + startDeg});
    })
};

window.searchUserForCircle = () => {
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
            var disabled = derived.members_id.indexOf(user.id) > -1; //user is member already
            $result.append(
                $('<li class="list-group-item list-group-item-action p-2">').append(
                    $('<div class="row no-gutters">').append(
                        $((disabled ? '<span' : '<a') + ' class="col-11" href="#">').html(user.name)
                            .on('click', () => {
                                if(!disabled) addMember(user.id, user.name, user.photo)
                            }),
                        $('<a class="col-1" href="#">').append('<img href="#" src="' + user.photo + '">')
                    )
                ).addClass(disabled ? 'list-group-item-success': '')
            )
        })
    })
};

jQuery.fn.extend({
    popMenu: function() {
        return $(this).each(function (i, elem) {
            var user_id = $(elem).data('id');
            $(elem).popover({
                container: 'body',
                placement: 'bottom',
                html: true,
                content: derived.getPopContent(user_id)
            })

        })
    }
});

var addMember = (id, name, photo) => {
    $('#s').val('');
    $('#s').focus();
    $('#search-result').empty();
    derived.members_id.push(id);

    axios({
        method: 'post',
        url: '/memberships/create',
        data: {user_id: id, circle_id: derived.circle_id}
    }).then((data) => {
        showNewAvatar(id, name, photo);
    }).catch((error) => {
        console.log(error.response);
        alert('Error!');
    });
};

window.deleteMember = (user_id) => {
    axios({
        method: 'post',
        url: '/memberships/delete',
        data: {user_id: user_id, circle_id: derived.circle_id}
    }).then((data) => {
        console.log(data);
        var index = derived.members_id.indexOf(user_id);
        if (index !== -1) derived.members_id.splice(index, 1);
        deleteAvatar(user_id);
    }).catch((error) => {
        console.log(error.response);
        alert('Error!');
    });
};

var showNewAvatar = (id, name, photo) => {
    var len = $('.avatar-container').length;
    (
        $('<div data-id="' + id +'" class="avatar-container">').append(
            $('<a href="#">').append(
                $('<div data-offset="0, 10%" data-toggle="tooltip" title="' + name + '" class="avatar-wrap w-100">').append(
                    $('<img data-id="' + id + '" src="' + photo + '">').popMenu()
                )
            )
        )
    ).insertAfter('.add-container')
    rotate(len + 1);
    $('.avatar-container').each((i, elem) => {
        //tricky solution for restart css anim
        // https://css-tricks.com/restart-css-animation/
        elem.classList.remove("avatar-container");
        void elem.offsetWidth;
        elem.classList.add("avatar-container");
    });
    initNewTooltips();
};

var deleteAvatar = (id) => {
    var $avatar = $('.avatar-container[data-id="' + id + '"]');
    $avatar.find('img').popover('dispose');
    $avatar.remove();
    var len = $('.avatar-container').length;
    rotate(len);
    $('.avatar-container').each((i, elem) => {

        //tricky solution for restart css anim
        // https://css-tricks.com/restart-css-animation/
        elem.classList.remove("avatar-container");
        void elem.offsetWidth;
        elem.classList.add("avatar-container");
    });
};

$('#add')
    .popover({
        placement: 'bottom',
        html: true,
        template: '<div class="popover w-100" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        content: '' +
            '<div></div>' +
            '<div class="input-group mb-1">' +
                '<input id="s" onkeypress="if(event.which == 13)searchUserForCircle()" autofocus class="form-control" placeholder="' + lang.search + '" type="text">' +
                '<div class="input-group-append">' +
                    '<button onclick="searchUserForCircle()" class="btn btn-outline-info"><i class="fas fa-search"></i></button>' +
                '</div>' +
            '</div>' +
            '<ul id="search-result" class="list-group">' +
            '</ul>'
    });

$('.avatar-wrap').find('img:not(.you)').popMenu();