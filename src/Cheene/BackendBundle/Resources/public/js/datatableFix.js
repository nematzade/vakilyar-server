var cheeneXHRPool = new Array();

function cheeneAbortAllAjax() {
    for (var i = 0; i < cheeneXHRPool.length; i++) {
        cheeneXHRPool[i].abort();
    }
}

var cheeneTimeout = null;
var cheeneSendAjax = false;
function callLastAjaxWithTimeout(_jqXHR) {
    try {
        clearTimeout(cheeneTimeout);
    }
    catch (e) {
        console.log('cannot clear timeout');
    }
    cheeneTimeout = setTimeout(function(){
        $.ajax(_jqXHR);
        cheeneSendAjax = true;
    }, 1000)
}

function isDataTableAjax(_url) {
    return (_url.indexOf('results?draw') > -1);
}

setTimeout(function() {
    $.ajaxSetup({
        beforeSend: function(jqXHR) {
            //timeOut = setTimeout(function() {
            //    $.ajax($.extend({beforeSend: $.noop}));
            //    cnt++;
            //    console.log(cnt);
            //}, 500);
            if(isDataTableAjax(this.url)) {
                if (cheeneSendAjax) {
                    cheeneSendAjax = false;
                    return true;
                }
                else {
                    //cheeneAbortAllAjax();
                    //cheeneXHRPool.push(jqXHR);
                    callLastAjaxWithTimeout(this);
                    return false;
                }
            }
            else {
                return true;
            }
        },
        complete: function(jqXHR) {
            //var index = cheeneXHRPool.indexOf(jqXHR);
            //if (index > -1) {
            //    cheeneXHRPool.splice(index, 1);
            //}
            if(isDataTableAjax(this.url)) {
                cheeneSendAjax = false;
            }
        }
    });
}, 2000)