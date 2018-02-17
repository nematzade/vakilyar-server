userIndex = {
    modal: $('#myModal'),
    init: function () {
        userIndex.eventHandler();
    },
    eventHandler: function () {
        $(document.body).on('click', '.edit_button', function (event) {
            event.preventDefault();
            userIndex.modal.find('.modal-body').empty();
            userIndex.modal.find('.modal-footer .save_button').remove();
            userIndex.modal.find('.modal-header').remove();
            var username = $(this).parents('tr').find('td:nth-child(2)').text();
            $.ajax({
                url: $(this).attr('href')
            })
                .done(function (data) {
                    userIndex.modal.find('.modal-content').prepend('<div class="modal-header user_index_modal_header">' + Translator.trans('label.users.fullname', {}, 'labels') + ' :‌ ' + username + '</div>');
                    userIndex.modal.find('.modal-body').html(data);
                    userIndex.modal.find('.modal-footer').prepend('<button class="btn green-jungle save_button">' + Translator.trans('button.update', {}, 'buttons') + '</button>');
                    $('.modal_role_form').find('#form_roles label:nth-child(4n)').after('<br>');
                })
                .fail(function (data) {
                    userIndex.modal.find('.modal-body').html('<div style="text-align:center; font-size:18px; margin:30px 0;">' + data.responseJSON.error.message + '</div>');
                })
                .always(function (data) {
                    $('#btn-modal').trigger('click');
                })

        });

        $('#myModal').on('click', '.save_button', function (event) {
            userIndex.loading(true, $('#myModal .modal-content'), true);
            event.preventDefault();
            form = $(this).parents('#myModal').find('form');
            $.ajax({
                url: form.attr('action'),
                type: 'PUT',
                data: form.serialize(),
            })
                .done(function () {
                    userIndex.loading(false, $('#myModal .modal-content'), true, Translator.trans('label.updated.successfully', {}, 'labels'));
                })
                .fail(function (data) {
                    userIndex.loading(false, $('#myModal .modal-content'), true, data);
                })
        });
        userIndex.modal.on('input', '.user-delta-credit', function (event) {
            user_delta_credit = parseInt($(this).val());
            $(this).parents('form').find('.user-credit').val(userIndex.current_user_credit + user_delta_credit);
        });
    },

    loading: function (status, parent, isblocking, message) {
        loaderElement = '<div class="loader-wrapper" data-blocking="' + isblocking + '"><div class="loader loading"><svg><circle class="loader-circle" cx="50%" cy="50%" r="40%"></circle></svg></div></div>';

        if (status) {
            parent.append(loaderElement)
        }
        else {
            setTimeout(function () {
                parent.find('.loader svg').remove();
                parent.find('.loader').append('<span class="loading-message">' + message + '</span> ');

                setTimeout(function () {
                    parent.find('.loader-wrapper').remove();
                }, 1000);

            }, 800);
        }
    }
};

