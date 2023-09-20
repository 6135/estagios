var Colaborador = function() {
    var setNewPassword = function() {
        $('button[name=setNewPassword]').click(function(event){
            event.preventDefault();
            //alert('setNewPassword');

            //colaboradorSetNewPasswordForm
            var x = $("#colaboradorSetNewPasswordForm").serializeArray();
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
                    url: "/colaborador/setpass",
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

    var init = function() {
        var myDropzone = new Dropzone("#cv_orientador_dropzone", {
            url: "empresa/novocolaborador", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            autoProcessQueue: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                // console.log(file.name);
                done();
            },
            success: function(file,data){
                myDropzone.removeFile(file);
                console.log('Received data:');

                data = JSON.parse(data);

                if(data['result']) {
                    console.log("????????")
                    toastr.success(
                        data['message'],
                        'Novo colaborador'
                    );
                    $('#btnNovoColaboradorSave').prop("disabled", false);

                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    $('#btnNovoColaboradorSave').prop("disabled", false);

                    toastr.error(
                        data['message'],
                        'Novo colaborador'
                    );
                }

                var idEmpresa = $('input[name=idempresa]').val();

                //preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                preencheSelect2EmpresaColaborador(idEmpresa);

            }
        });
        myDropzone.on('sending', function (file,xhr,formData){
            var x = $("#novoColaboradorForm").serializeArray();

            $.each(x, function(i, field){
                formData.append(field.name, field.value);
            });

        });
        $('#btnNovoColaboradorSave').click(function(event) {
            myDropzone.processQueue();
            // $('#btnNovoColaboradorSave').prop("disabled", true);
        });

        $('#btnNovoColabosradorSave').click(function(event){
            console.log("asdasdasdasd2");
            var x = $("#novoColaboradorForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // console.log(myData);
            $('#btnNovoColaboradorSave').prop("disabled", true);

            $.ajax({
                type: "POST",
                url: "/empresa/novocolaborador",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    console.log('Received data:');
                    console.log(data);
                    if(data.result) {
                        toastr.success(
                            data.message,
                            'Novo colaborador'
                        );
                        $('#btnNovoColaboradorSave').prop("disabled", false);

                        setTimeout(function(){
                            //location.reload();
                        }, 1500);
                    } else {
                        $('#btnNovoColaboradorSave').prop("disabled", false);

                        toastr.error(
                            data.message,
                            'Novo colaborador'
                        );
                    }

                    var idEmpresa = $('input[name=idempresa]').val();

                    //preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    preencheSelect2EmpresaColaborador(idEmpresa);
                },
                error: function(errMsg) {
                    $('#btnNovoColaboradorSave').prop("disabled", false);

                    toastr.error(
                        'Ocorreu erro desconhecido, verifique campos ou contacte helpdesk@dei.uc.pt',
                        'Erro',
                    );
                }
            });


        });
        $('#checkExperienciaRelevante').change(function (){
            let parentAnos = $('#anos').parent();
            if(this.checked){
                parentAnos.show();
            } else {
                parentAnos.hide();
            }
        });

    };

    var preencheSelect2EmpresaColaborador = function(idEmpresa) {
        $('input[name=idempresa]').val(idEmpresa);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/empresa/colaboradores/select2list/" + idEmpresa,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                $('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
    }

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
    Colaborador.init();
});