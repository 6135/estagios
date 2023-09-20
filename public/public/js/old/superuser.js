var Superuser = function() {
    var init = function() {
        askForApproval();
        initCheckEvents();
        ajaxInit();
    };

    var ajaxInit = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    var initCheckEvents = function() {
        setInterval(function () {
            var myData = new Object();

            $.ajax({
                type: "POST",
                url: "/su/events/get",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    console.log('Received data:');
                    console.log(data);

                    if(data.result) {
                        if(Notification.permission === "granted") {
                            createNotification(data.message, data.description, 'https://estagiosadminv2.dei.uc.pt/favicon.ico');
                        }
                        toastr.success(
                            data.message,
                            data.description
                        );
                    }/*else {
                        toastr.error(
                            data.message,
                            data.description
                        );
                    }*/
                },
                error: function(errMsg) {
                    toastr.error(
                        'Ocorreu erro desconhecido, verifique campos ou contacte helpdesk@dei.uc.pt',
                        'Erro',
                    );
                }
            });
        }, 5000);
    };

    var askForApproval = function() {
        env()
        if(Notification.permission === "granted") {
            createNotification('Hi 1', 'created by SIC@DEI', 'https://estagiosadminv2.dei.uc.pt/favicon.ico');
        }
        else {
            Notification.requestPermission(permission => {
                console.log(permission);

                if(permission === 'granted') {
                    createNotification('Hi 2', 'created by SIC@DEI', 'https://estagiosadminv2.dei.uc.pt/favicon.ico');
                }
            });
        }
    }

    var createNotification = function(title, text, icon) {
        const noti = new Notification(title, {
            body: text,
            icon
        });
    }

    return {
        init: function() {
            init();
        },
    };
}();


jQuery(document).ready(function() {
    Superuser.init();
});