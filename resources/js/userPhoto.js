const croppie = require('croppie');

const $form = $('#image-picker').find('form');
if($form.length > 0) {
    $form.on('dragover', (e) => {
        e.preventDefault();
        $form.addClass('dragging');
    });

    $form.on('dragleave', () => {
        $form.removeClass('dragging');
    });

    $form.on('drop', (e) => {
        e.preventDefault();
        $form.removeClass('dragging');

        $('input#photo')[0].files = e.originalEvent.dataTransfer.files;
    });

    const resize = $('#crop').croppie({
        enableExif: true,
        enableOrientation: true,
        viewport: {
            width: 500,
            height: 500,
            type: 'circle'
        },
        boundary: {
            width: 500,
            height: 500
        }
    });

    if(window.photo_url !== undefined) {
        $('.crop-container').removeClass('d-none');
        resize.croppie('bind',{
            url: photo_url
        })
    }

    $('input#photo').on('change', (e) => {
        if(e.target.files.length > 0) {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);

            reader.onload = (e) => {
                $('.crop-container').removeClass('d-none');
                resize.croppie('bind',{
                    url: e.target.result
                })
            };
        }
    });

    $('#upload').on('click', () => {
        resize.croppie('result', {
            type: 'blob',
            size: 'viewport'
        }).then(function (img) {
            const fd = new FormData;
            fd.append('photo', img);
            axios({
                method: 'post',
                headers: { 'Content-Type': 'multipart/form-data' },
                url: '/users/uploadPhoto',
                data: fd
            }).then(() => {
                location.reload();
            })
        });
    })
}

