var RepresentanteLegal = function() {
    var setNewPassword = function() {
        $('button[name=setNewPassword]').click(function(event){
            event.preventDefault();
            //alert('setNewPassword');

            //colaboradorSetNewPasswordForm
            var x = $("#representanteSetNewPasswordForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //console.log(myData);

            if(myData.password1 == myData.password2) {
                $('button[name=setNewPassword]').prop("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "/representante/setpass",
                    data: JSON.stringify(myData),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data) {
                        console.log('Received data:');
                        console.log(data);

                        if(data.result) {
                            toastr.success(
                                data.message,
                                'Definição de nova password'
                            );

                            setTimeout(function(){
                                window.location.replace("/");
                            }, 3000);
                        } else {
                            $('button[name=setNewPassword]').prop("disabled", false);

                            toastr.error(
                                data.message,
                                'Definição de nova password'
                            );
                        }
                    },
                    error: function(errMsg) {
                        $('button[name=setNewPassword]').prop("disabled", false);
                    }
                });
            } else {
                toastr.error(
                    'Passwords diferem',
                    'Definição de nova password'
                );
            }
        });
    };

    var init = function() {
        $('#btnNovoRepresentanteLegalSave').click(function(){
            var x = $("#novoRepresentanteLegalForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#btnNovoRepresentanteLegalSave').prop("disabled", true);

            $.ajax({
                type: "POST",
                url: "/empresa/novorepresentantelegal",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    if(data.result) {
                        toastr.success(
                            data.message,
                            data.title,
                        );

                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else {
                        $('#btnNovoRepresentanteLegalSave').prop("disabled", false);
                        toastr.error(
                            data.message,
                            data.title,
                        );
                    }
                },
                error: function (errMsg) {
                    $('#btnNovoRepresentanteLegalSave').prop("disabled", false);
                    toastr.error(
                        'Ocorreu erro desconhecido, verifique campos ou contacte helpdesk@dei.uc.pt',
                        'Erro',
                    );
                    //toastr.error(options['ajaxError'], options['ajaxErrorTitle']);
                }
            });
        });
    };

    return {
        init: function() {
            init();
        },
        setNewPassword: function() {
            setNewPassword();
        }
    };
}();


jQuery(document).ready(function() {
    RepresentanteLegal.init();
});