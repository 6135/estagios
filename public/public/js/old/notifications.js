var Notifications = function() {
    var init = function() {
        askForApproval();
    };

    var askForApproval = function() {
        if(Notification.permission === "granted") {
            createNotification('Hi', 'created by SIC@DEI', 'https://estagiosadminv2.dei.uc.pt/favicon.ico');
        }
        else {
            Notification.requestPermission(permission => {
                console.log(permission);

                if(permission === 'granted') {
                    createNotification('Hi', 'created by SIC@DEI', 'https://estagiosadminv2.dei.uc.pt/favicon.ico');
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

    var wsClientInit = function() {
        const socket = new WebSocket('wss://bo.estagios.dei.uc.pt:8080');
        //const socket = new WebSocket('ws://vps01.kineth.com:8080/teste/123?a=b');
        //const socket = new WebSocket('ws://vps01.kineth.com:8080');

        socket.addEventListener('open', function (event) {
            socket.send('Connection Established');
        });

        socket.addEventListener('message', function (event) {
            console.log(event.data);
            if(event.data.includes("ALERT")) {
                alert(event.data);
            }
        });

        const contactServer = () => {
            //console.log('Initialize');
            //socket.send("ALERT 1 2 3 4");
            socket.send('{"action": "gotourl", "url": "http://my2.dei.uc.pt/stock/artview/' + $('input[name=artid]').val() + '/T"}');
        }

        const contactServerB = () => {
            //console.log('HELLO');
            socket.send("HELLO");
        }
    }

    return {
        init: function() {
            init();
            wsClientInit();
        },
    };
}();


jQuery(document).ready(function() {
    Notifications.init();
});