var CHEENE_FRAMEWORK = {

	init: function(argument) {
        $('.page-sidebar-menu > li > ul > li.active').parent().parent().addClass('active');
	},

	loading: function(status, parent, isblocking, message){
        loaderElement = '<div class="loader-wrapper" data-blocking="'+isblocking+'"><div class="loader loading"><svg><circle class="loader-circle" cx="50%" cy="50%" r="40%"></circle></svg></div></div>';

        if(status){
            parent.append(loaderElement)
        }
        else{
            setTimeout(function(){
                parent.find('.loader svg').remove();
                parent.find('.loader').append('<span class="loading-message">'+message+'</span> ');

                setTimeout(function(){
                    parent.find('.loader-wrapper').remove();
                }, 1000);

            }, 800);
        }
    },

    showNotif: function(type, msg, title, timeOut){
        if (timeOut === undefined) {
            timeOut = 5500;
        }
        // type : info, success, error, warning
        if(!msg){
            if(type == "success"){
                msg = 'با موفقیت ثبت شد';
            }
            else if(type == "error"){
                msg = 'خطایی رخ داده است';
            }
            else if(type == "info"){
                msg = 'تغییری صورت نگرفته است'
            }
            else if(type == "warning"){
                msg = 'موارد خواسته شده را وارد کنید'
            }
            else{
                type = 'error'
                msg = 'نا مشخص';
            }
        }

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-top-right',
            onclick: null,
            showDuration: 500,
            hideDuration: 500,
            timeOut: timeOut,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        toastr[type](msg, title);
    },
    
}
