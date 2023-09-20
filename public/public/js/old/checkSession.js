var CheckSession = function() {
    var check = function(response) {
        if(!response.status) {
            //console.log('----------------------------------------------------------------------------------------------------');

            if(response.redirect) {
                if(response.redirect.status) {
                    window.location.replace(response.redirect.url);
                }
            }

            //console.log('----------------------------------------------------------------------------------------------------');
        }
    };

    var checkNoRedirect = function(response) {
        if(!response.status) {
            //console.log('----------------------------------------------------------------------------------------------------');

            if(response.redirect) {
                if(response.redirect.status) {
                    //alert('123');
                    $('#m_modal_4').modal('show');

                    /*var win = window.open('{{env('APP_URL')}}/loginpage', '_blank');

                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {
                        //Browser has blocked it
                        alert('Please allow popups for this website');
                    }*/
                }
            }

            //console.log('----------------------------------------------------------------------------------------------------');
        }
    };

    var init = function() {
        console.log('CheckSession init()');
    };

    return {
        init: function() {
            init();
        },
        check: function(response) {
            check(response);
        },
        checkNoRedirect: function(response) {
            checkNoRedirect(response);
        },
    };
}();


jQuery(document).ready(function() {
    CheckSession.init();
});