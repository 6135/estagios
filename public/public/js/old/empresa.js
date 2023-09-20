var Empresa = function() {
    var init = function() {

    };

    var setNewPassword = function() {
        $('button[name=setNewPassword]').click(function(event){
            event.preventDefault();
            //alert('setNewPassword');

            //empresaSetNewPasswordForm
            var x = $("#empresaSetNewPasswordForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log(myData);

            if(myData.password1 == myData.password2) {
                $('button[name=setNewPassword]').prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "/empresa/setpass",
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

                        toastr.error(
                            'Ocorreu erro desconhecido, verifique campos ou contacte helpdesk@dei.uc.pt',
                            'Erro',
                        );
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

    var myPost = function(options, myData) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: options['ajaxUrl'],
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
                    toastr.error(
                        data.message,
                        data.title,
                    );
                }
            },
            error: function (errMsg) {
                toastr.error(options['ajaxError'], options['ajaxErrorTitle']);
            }
        });
    }

    var dadosEmpresa = function() {
        //COLABORADORES
        $('#colaborador-desactiva').click(function(event){
            console.log('colaborador-desactiva');
            console.log($(this).parent().parent().parent().parent().attr('colaboradorId'));

            var options = new Object();

            options['ajaxUrl'] = '/colaborador/activacao';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().parent().parent().attr('colaboradorId');
            myData['activa'] = 0;

            myPost(options, myData);
        });

        $('button[name=colaborador-activa]').click(function(event){
            console.log('colaborador-activa');
            console.log($(this).parent().parent().attr('colaboradorId'));

            var options = new Object();

            options['ajaxUrl'] = '/colaborador/activacao';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().attr('colaboradorId');
            myData['activa'] = 1;

            myPost(options, myData);
        });

        $('#colaborador-recupera').click(function(event){
            console.log('colaborador-recupera');

            var options = new Object();

            options['ajaxUrl'] = '/colaborador/recuperapassword';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().parent().parent().attr('colaboradorId');

            myPost(options, myData);
        });


        //REPRESENTANTES
        $('button[name=representante-desactiva]').click(function(event){
            console.log('representante-desactiva');
            console.log($(this).parent().parent().attr('representanteId'));

            var options = new Object();

            options['ajaxUrl'] = '/representante/activacao';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().attr('representanteId');
            myData['activa'] = 0;

            myPost(options, myData);
        });

        $('button[name=representante-activa]').click(function(event){
            console.log('representante-activa');
            console.log($(this).parent().parent().attr('representanteId'));

            var options = new Object();

            options['ajaxUrl'] = '/representante/activacao';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().attr('representanteId');
            myData['activa'] = 1;

            myPost(options, myData);
        });

        $('button[name=representante-recupera]').click(function(event){
            console.log('representante-recupera');
            console.log($(this).parent().parent().attr('representanteId'));

            var options = new Object();

            options['ajaxUrl'] = '/representante/recuperapassword';
            options['ajaxError'] = 'Erro ao comunicar com o servidor...';
            options['ajaxErrorTitle'] = 'Erro de comunicação';

            var myData = new Object();
            myData['id'] = $(this).parent().parent().attr('representanteId');

            myPost(options, myData);
        });

        $('button[name=save]').click(function(event){
            event.preventDefault();

            var formData = $("#empresaForm").serializeArray();

            /*var formData = new Object();
            formData.nome = $('input[name=nome]').val();
            formData.acronimo = $('input[name=acronimo]').val();
            //formData.nif = $('input[name=nif]').val();
            formData.actividade = $('div[name=actividade]');
            formData.sede = $('input[name=sede]').val();
            formData.url = $('input[name=url]').val();
            //formData.email = $('input[name=email]').val();
            formData.telefone = $('input[name=telefone]').val();
            formData.ddeclaracao = $('input[name=ddeclaracao]').val();
            formData.cbdeclaracao = $('input[name=cbdeclaracao]').prop("checked");

            console.log(formData);*/

            var myData = new Object();

            $.each(formData, function(i, field){
                myData[field.name] = field.value;
            });

            myData['cbdeclaracao'] = $('input[name=cbdeclaracao]').prop("checked");
            myData['actividade'] = $('#actividade').val();

            console.log("data: " + myData['actividade']);


            if(myData['cbdeclaracao']==false) {
                toastr.error('Verifique a declaração da veracidade dos dados', 'Dados da empresa');
            } else {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/dadosempresa/save",
                    data: JSON.stringify(myData),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
                        console.log('Received data:');
                        console.log(data);
                        //alert(data.message);
                        toastr.success('Dados gravados com sucesso', 'Dados da empresa');
                    },
                    error: function (errMsg) {
                        toastr.error('Erro ao gravar dados da empresa', 'Dados da empresa');
                    }
                });
            }
        });
    };

    return {
        init: function() {
            var actividade = $('input[name=actividadehidden]').val();
            //$('div[name=actividade]').summernote('code', actividade);
        },
        dadosEmpresa: function() {
            dadosEmpresa();
        },
        setNewPassword: function() {
            setNewPassword();
        }
    };
}();


jQuery(document).ready(function() {
    Empresa.init();
});