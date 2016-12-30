$(document).ready(function () {

    $(".img-link").click(function(e){
        e.preventDefault();
        cardId = $(this).attr('rel');
        if($('#'+cardId).length){
            $card = $('#'+cardId);
            $('.vilage-card-wrap').hide();
            $card.show();
        }
    });
    $('.vilage-card-open .card-close').click(function(e){
        e.preventDefault();
        $('.vilage-card-wrap').show();
        $('.vilage-card-open').hide();

    });
    $('[name="phone"]').inputmask();
    $('#register-facility, #register-facility-wide').submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var formValues = $form.serializeArray();
        $.post('/api/v1/facilities/registration', formValues)
            .done(function (data) {
                $form.find('.form-group').hide();
                var phone = $form.find('[name="phone"]').val();
                $('#confirm-popup').find('[name="phone"]').val(phone);
                $form.append('<div class="message-success">' + data.message + '</div>');
                // Reattach behaviors needed for pop-up in message text.
                villageLanding.runBehaviors(document);

            })
            .fail(function (data) {
                for (var fieldName in data.responseJSON.error.message) {
                    $form.find('[name="' + fieldName + '"]').addClass('field-error');
                }
            })
    });

    if($('#login-popup .field-error').length  || $('#login-popup .alert-danger').length)
    {
        villageLanding.Functions.openPopup('login');
    }
    $('#reset-password').submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var formValues = $form.serializeArray();
        $.post('/api/v1/users/reset-code', formValues)
            .always(function (data) {
                $form.find('span.error').remove();
            })
            .done(function (data) {
                $form.find('.form-group').hide();
                $form.append('<div class="message-success">' + data.message + '</div>');
                var phone = $form.find('[name="phone"]').val();
                $('#change-password').find('[name="phone"]').val(phone);
                villageLanding.runBehaviors(document);
            })
            .fail(function (data) {
                // Code or phone not found
                if(data.status == 404 || data.status == 403)
                {
                    $form.find('[name="phone"]').addClass('field-error');
                    $form.find('[name="phone"]').after('<span class="error">'+data.responseJSON.error.message + '</span>');
                }
                if(data.status == 400){
                    for (var fieldName in data.responseJSON.error.message) {
                        var field = $form.find('[name="' + fieldName + '"]');
                        field.addClass('field-error');
                        field.after('<span class="error">'+ data.responseJSON.error.message[fieldName] + '</span>');
                    }
                }
            });
    });

    $('#change-password form').submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var formValues = $form.serializeArray();
        $.post('/api/v1/users/reset-by-code', formValues)
            .done(function (data) {
                $form.find('.form-group').hide();
                $form.append('<div class="message-success">' + data.message + '</div>');
                $form.unbind('submit').submit()
            })
            .always(function (data) {
                $form.find('span.error').remove();
            })
            .fail(function (data) {
                // Code or phone not found
                if(data.status == 404 || data.status == 403)
                {
                    $form.find('[name="phone"]').before('<span class="error">'+data.responseJSON.error.message + '</span>');
                    $form.find('[name="code"]').addClass('field-error');
                }
                for (var fieldName in data.responseJSON.error.message) {
                    var field = $form.find('[name="' + fieldName + '"]');
                    field.addClass('field-error');
                    field.after('<span class="error">'+ data.responseJSON.error.message[fieldName] + '</span>');
                }
            });
    });

    $('#confirm-popup form').submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var formValues = $form.serializeArray();
        $.post('/api/v1/facilities/confirm', formValues)
            .done(function (data) {
                $form.find('.form-group').hide();
                $form.append('<div class="message-success">' + data.message + '</div>');
                $form.unbind('submit').submit()
            })
            .always(function (data) {
                $form.find('span.error').remove();
            })
            .fail(function (data) {
                // Code or phone not found
                if(data.status == 404 || data.status == 403)
                {
                    $form.find('[name="phone"]').before('<span class="error">'+data.responseJSON.error.message + '</span>');
                    $form.find('[name="phone"]').addClass('field-error');
                    $form.find('[name="code"]').addClass('field-error');
                }
                for (var fieldName in data.responseJSON.error.message) {
                    var field = $form.find('[name="' + fieldName + '"]');
                    field.addClass('field-error');
                    field.after('<span class="error">'+ data.responseJSON.error.message[fieldName] + '</span>');
                }
            });
    });

    //$('#rates .headline span')
})

