var ThisFormControls = function() {
    var init = function() {
        consoleLog('INIT');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.m_form_selectpicker').selectpicker();

        $("input[name=estagio-titulo]").focusout(function(){
            //formSaveOrUpdate();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            changeSelect();
        });

        $('#btnNovoRepresentanteLegalSave').click(function(){
            /*var x = $("#novoRepresentanteLegalForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/empresa/novorepresentantelegal",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    consoleLog('Received data:');
                    consoleLog(data);
                    alert(data.message);

                    var idEmpresa = $('input[name=idempresa]').val();

                    preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    //preencheSelect2EmpresaColaborador(idEmpresa);
                },
                error: function(errMsg) {
                    //consoleLog(errMsg);
                }
            });*/
        });
        $('#btnNovoColaboradorSave').click(function(){
            /*var x = $("#novoColaboradorForm").serializeArray();
            var myData = new Object();

            $.each(x, function(i, field){
                myData[field.name] = field.value;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/empresa/novocolaborador",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    consoleLog('Received data:');
                    consoleLog(data);
                    alert(data.message);

                    var idEmpresa = $('input[name=idempresa]').val();

                    //preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    preencheSelect2EmpresaColaborador(idEmpresa);
                },
                error: function(errMsg) {
                    //consoleLog(errMsg);
                }
            });*/
        });

        //buttonEstagioSubmit

        $('#buttonLogin').click(function(event) {
            event.preventDefault();

            consoleLog("Login");

            var btn = $(this);
            var form = $(this).closest('form');

            form.ajaxSubmit({
                url: '/thelogin',
                success: function(response, status, xhr, $form) {
                    //btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);

                    var serverResponse = jQuery.parseJSON(response);

                    consoleLog(serverResponse);

                    if(serverResponse.success) {
                        //alert('ok');
                        $('#m_modal_4').modal('hide');
                        //window.location.href = '/dashboard/';
                    } else {
                        if(serverResponse.message) {
                            alert(serverResponse.message);
                            //showErrorMsg(form, 'danger', serverResponse.message);
                        } else {
                            alert("unknown error");
                            //showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
                        }
                    }
                }
            });
        });

        $('#buttonEstagioSubmit').click(function(event) {
            event.preventDefault();

            formSaveOrUpdate(function(){
                //alert('DONE');
                formSetSubmited();
            });
        });

        $('#buttonEstagioSave').click(function(event) {
            event.preventDefault();

            consoleLog("SAVE");
            formSaveOrUpdate(function(){
            });
        });
    };

    var formSetSubmited = function() {
        consoleLog("buttonEstagioSubmit");
        var idEstagio = $('input[name=idestagio]').val();

        var myData = new Object();
        myData.idEstagio = idEstagio;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.modal-submit-estagio-message').text('');

        $.ajax({
            type: "POST",
            url: "/estagios/setsubmited",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                $('.modal-submit-estagio-message').text(data.message);
                if(data.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 2500);
                }
                setTimeout(function() {
                    $('.modal-submit-estagio-message').text('');
                }, 5000);
            },
            error: function(errMsg) {
                consoleLog(errMsg);
            }
        });
    };

    var changeSelect = function() {
        $("select.m-select2").select2({
            tags: true
        });
    };

    var formSaveOrUpdate = function(successCallbackFunction) {
        consoleLog('formSaveOrUpdate');

        var id = $('input[name=idestagio]').val();

        consoleLog("----------------------> [" + id + "]");
        consoleLog("----------------------> [" + id.length + "]");

        if(id.length==0) {
            formSave(id, successCallbackFunction);
        } else {
            formUpdate(id, successCallbackFunction);
        }

        consoleLog(id);
    }
    
    var consoleLog = function(data) {
        if(false) {
            console.log(data);
        }
    }

    var formSave = function(id, successCallbackFunction) {
        consoleLog('formSave(' + id + ')');

        var formData = $("#propostaEstagioForm").serializeArray();

        /*var formData = new Object();
        formData.nome = $('input[name=nome]').val();
        formData.acronimo = $('input[name=acronimo]').val();
        //formData.nif = $('input[name=nif]').val();
        formData.actividade = $('div[name=actividade]').summernote('code');
        formData.sede = $('input[name=sede]').val();
        formData.url = $('input[name=url]').val();
        //formData.email = $('input[name=email]').val();
        formData.telefone = $('input[name=telefone]').val();
        formData.ddeclaracao = $('input[name=ddeclaracao]').val();
        formData.cbdeclaracao = $('input[name=cbdeclaracao]').prop("checked");*/

        var myData = new Object();

        $.each(formData, function(i, field){
            myData[field.name] = field.value;
        });

        /*myData['enquadramento'] = $('#m_summernote_1').summernote('code');
        myData['objectivoestagio'] = $('#m_summernote_2').summernote('code');
        myData['ptrabalhosestagio'] = $('#m_summernote_3').summernote('code');
        myData['ptrabalhosestagio2'] = $('#m_summernote_4').summernote('code');
        myData['condicoesestagios'] = $('#m_summernote_5').summernote('code');
        myData['observacoesestagio'] = $('#m_summernote_6').summernote('code');*/

        consoleLog('formData: [');
        consoleLog(myData);
        consoleLog(']');

        //$('input[name=idestagio]').val(99);

        //$('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        //INSERT
        $.ajax({
            type: "POST",
            url: "/estagios/propostas/savedata",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.checkNoRedirect(data);

                let searchParams = new URLSearchParams(window.location.search);
                consoleLog(searchParams);

                //alert('123');
                consoleLog(':: data: [');
                consoleLog(data);
                consoleLog(']');

                consoleLog(':: result: [');
                consoleLog(data.result);
                consoleLog(']');

                if(data.result) {
                    var idestagio = data.idestagio;
                    setTimeout(function() {
                        toastr.error('A proposta só é considerada depois de a submeter.', 'Importante');
                    }, 4000);
                    toastr.success(data.message, 'Estagio');

                    var aux = window.location.pathname.includes(idestagio);

                    if(idestagio!==undefined) {
                        if(aux == false) {
                            //consoleLog("---------------------->", aux, "<-----------------------");
                            setTimeout(function() {
                                window.location.replace("/estagios/propostas/nova/" + idestagio);
                            }, 2500);
                            //consoleLog(idestagio + " FALSE: REDIRECT");
                        }
                    }

                    /*setTimeout(function() {
                        consoleLog(data.idestagio);
                        window.location.replace("/estagios/propostas/nova/" + data.idestagio);
                    }, 2500);*/

                    //$('#maintab_2').trigger('click');
                    consoleLog("data.idestagio : ");
                    consoleLog(data.idestagio);
                    $('input[name=idestagio]').val(data.idestagio);

                    successCallbackFunction();
                } else {
                    toastr.error(data.message, 'Estagio');
                }

                /*$('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });*/
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });

        //toastr.success('Dados do estágio guardados', 'Estagio');
    }

    var formUpdate = function(id, successCallbackFunction) {
        setTimeout(function() {
            toastr.error('A proposta só é considerada depois de a submeter.', 'Importante');
        }, 4000);
        consoleLog('formUpdate(' + id + ')');

        var formData = $("#propostaEstagioForm").serializeArray();
        var formDataJSON = $("#propostaEstagioForm").serializeJSON();

        consoleLog('-------------------- formDataJSON --------------------');
        consoleLog(formDataJSON);
        consoleLog('-------------------- formDataJSON --------------------');

        /*var formData = new Object();
        formData.nome = $('input[name=nome]').val();
        formData.acronimo = $('input[name=acronimo]').val();
        //formData.nif = $('input[name=nif]').val();
        formData.actividade = $('div[name=actividade]').summernote('code');
        formData.sede = $('input[name=sede]').val();
        formData.url = $('input[name=url]').val();
        //formData.email = $('input[name=email]').val();
        formData.telefone = $('input[name=telefone]').val();
        formData.ddeclaracao = $('input[name=ddeclaracao]').val();
        formData.cbdeclaracao = $('input[name=cbdeclaracao]').prop("checked");*//*csrf-token ???????? */

        var myData = new Object();

        $.each(formData, function(i, field) {
            myData[field.name] = field.value;
            consoleLog(field.name );
        });

        /*myData['enquadramento'] = $('#m_summernote_1').summernote('code');
        myData['objectivoestagio'] = $('#m_summernote_2').summernote('code');
        myData['ptrabalhosestagio'] = $('#m_summernote_3').summernote('code');
        myData['ptrabalhosestagio2'] = $('#m_summernote_4').summernote('code');
        myData['condicoesestagios'] = $('#m_summernote_5').summernote('code');
        myData['observacoesestagio'] = $('#m_summernote_6').summernote('code');*/

        //myData['orientadorempresa'] = $('#m_summernote_6').summernote('code');



        consoleLog('formData: [');
        consoleLog(myData);
        consoleLog(']');

        //$('input[name=idestagio]').val(99);

        //$('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        //UPDATE
        $.ajax({
            type: "POST",
            url: "/estagios/propostas/savedata",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.checkNoRedirect(data);

                //let searchParams = new URLSearchParams(window.location.search);

                //alert('formUpdate');
                consoleLog(':: data: [');
                consoleLog(data);
                consoleLog(']');

                consoleLog(':: result: [');
                consoleLog(data.result);
                consoleLog(']');

                if(data.result) {
                    var idestagio = data.idestagio;
                    toastr.success(data.message, 'Estagio');

                    var aux = window.location.pathname.includes(idestagio);

                    if(idestagio!==undefined) {
                        if(aux == false) {
                            //consoleLog("---------------------->", aux, "<-----------------------");
                            setTimeout(function() {
                                window.location.replace("/estagios/propostas/nova/" + idestagio);
                            }, 2500);
                            consoleLog(idestagio + " FALSE: REDIRECT");
                        } else {
                            consoleLog("TRUE");
                        }
                    }

                    /*setTimeout(function() {
                        window.location.replace("/estagios/propostas/nova/" . data.idestagio);
                    }, 2500);*/
                    consoleLog("data.idestagio : ");
                    consoleLog(data.data.idestagio);
                    $('input[name=idestagio]').val(data.data.idestagio);

                    successCallbackFunction();
                } else {
                    toastr.error(data.message, 'Estagio');
                }

                /*$('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });*/
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });

        //toastr.success('Dados do estágio guardados', 'Estagio');
    }

    //== Private functions
    //var validator;

    var initWidgets = function() {
        // select2
        $('#m_select2_docentes').select2({
            placeholder: "Seleccione um docente",
            width: 'resolve',
        });

        $('#m_select2_empresas').select2({
            placeholder: "Seleccione uma instituição",
            width: 'resolve',
        });

        $('#m_select2_periodos_estagio').select2({
            placeholder: "Seleccione um período de estágio",
            width: 'resolve',
        });

        $('#m_select2_area_especialidade').select2({
            placeholder: "Seleccione a área de especialidade",
            width: 'resolve',
        });

        $('#m_select2_area_especialidade_opcional').select2({
            placeholder: "Seleccione a área de especialidade",
            width: 'resolve',
        });

        $('#m_select2_orientadorempresa').select2({
            placeholder: "Seleccione um orientador na empresa",
            width: 'resolve',
        });

        $('#m_select2_empresas_representante').select2({
            placeholder: "Seleccione o representante legal da empresa",
            width: 'resolve',
        });
        $('#m_select2_empresas_colaborador').select2({
            placeholder: "Seleccione o contacto administrativo da empresa",
            width: 'resolve',
        });
    }

    var initWidgetsCallbacks = function() {
        $('#m_select2_docentes').on('select2:change', function(){
            //validator.element($(this)); // validate element
            //$('#m_form_periodo_estagio_doc').append($('<option>').text($(this).value()));

            consoleLog('changed');

            var docente = $('#m_select2_docentes').select2('data');
            alert(docente);
        });

        /*$('#m_select2_docentes').on('change', function(){
            consoleLog(this.value);
        });*/

        $('#m_select2_empresas').on('change', function(){
            var idEmpresa = this.value;

            consoleLog("empresa: " + idEmpresa);

            $('input[name=idempresa]').val(idEmpresa);

            preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
            preencheSelect2EmpresaColaborador(idEmpresa);
        });
    }

    var preencheSelect2EmpresaColaborador = function(idEmpresa, callback) {
        $('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/empresa/colaboradores/select2list/" + idEmpresa,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                $('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });

                if (callback !== undefined) {
                    callback();
                }
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var preencheSelect2EmpresaRepresentanteLegal = function(idEmpresa, callback) {
        $('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/empresa/representantes/select2list/" + idEmpresa,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                consoleLog("/empresa/representantes/select2list/");
                consoleLog(data);

                $('#m_select2_empresas_representante').find('option').remove();

                $('#m_select2_empresas_representante').append($('<option>').text('Seleccione o representante legal da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_representante').append($('<option>').text(value.nome).val(value.id));
                });

                if (callback !== undefined) {
                    callback();
                }
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var datepickerFormat = function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    };

    var preencheSelect2Docentes = function() {
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/docentes/select2List",
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                //consoleLog('Received data:');
                //consoleLog(data);
                //$('#m_select2_docentes').html('');
                $('#m_select2_docentes').find('option').remove();

                $('#m_select2_docentes').append($('<option>').text('default@dei.uc.pt').val(1));

                $.each(data, function(index, value) {
                    $('#m_select2_docentes').append($('<option>').text(value.nome).val(value.id));
                });

                initWidgetsCallbacks();
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var preencheSelect2Empresas = function() {
        consoleLog('preencheSelect2Empresas');

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/empresa/select2List",
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                //consoleLog('Received data:');
                //consoleLog(data);
                //$('#m_select2_empresas').html('');

                $('#m_select2_empresas').find('option').remove();

                $('#m_select2_empresas').append($('<option>').text('Seleccione a empresa').val(-1));//.attr('disabled', 'disabled'));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas').append($('<option>').text(value.nome).val(value.id));
                });

                initWidgetsCallbacks();
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var preencheSelect2PeriodosEstagioCallback = function() {
        $('#m_select2_periodos_estagio').on('change', function(){
            var id = this.value;
            consoleLog(id);
            cursoGetTitulo(id);

            //ESCONDE TODOS
            $('.inputs-curso').hide();

            //MOSTRA O NECESSÁRIO
            $('.inputs-curso-' + id).show();
        });

        var theVal = $('#m_select2_periodos_estagio').val();
        cursoGetTitulo(theVal);
    }

    var preencheSelect2PeriodosEstagio = function() {
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/estagios/periodos/select2list",
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                consoleLog('Received data:');
                consoleLog(data);
                //$('#m_select2_periodos_estagio').html('');

                $.each(data, function(index, value) {
                    consoleLog('---->');
                    consoleLog(value);
                    $('#m_select2_periodos_estagio').append($('<option>').text(value.descricao).val(value.id));
                });

                preencheSelect2PeriodosEstagioCallback();
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var preencheSelect2OrientadorEmpresaCallback = function() {
        $('#m_select2_orientadorempresa').on('change', function(){
            //consoleLog(this.attr('info'));
            consoleLog(this);
            orientadorEmpresaDetalhes(this.value);
        });
    }

    var preencheSelect2OrientadorEmpresa = function() {
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/empresa/orientadores/select2list",
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                //consoleLog('Received data:');
                //consoleLog(data);
                //$('#m_select2_periodos_estagio').html('');

                $.each(data, function(index, value) {
                    //$('#m_select2_orientadorempresa').append($('<option>').text(value.orientadorempresa).val(value.idestagio).attr('info',20));
                    $('#m_select2_orientadorempresa').append($('<option>').text(value.orientadorempresa).val(value.idestagio));
                });

                preencheSelect2OrientadorEmpresaCallback();
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }


    var preencheSelect2AreaEspecialidade = function() {
        $('#m_select2_area_especialidade').find('option').remove();
        $('#m_select2_area_especialidade').append($('<option>').text('Não seleccionada').val(0));
        $('#m_select2_area_especialidade').append($('<option>').text('Comunicações, Serviços e Infraestruturas').val(1));
        $('#m_select2_area_especialidade').append($('<option>').text('Engenharia de Software').val(2));
        $('#m_select2_area_especialidade').append($('<option>').text('Sistemas de Informação').val(3));
        $('#m_select2_area_especialidade').append($('<option>').text('Sistemas Inteligentes').val(4));

        consoleLog("preencheSelect2AreaEspecialidade()");
    }

    var preencheSelect2AreaEspecialidadeOpcional = function() {
        $('#m_select2_area_especialidade_opcional').find('option').remove();
        $('#m_select2_area_especialidade_opcional').append($('<option>').text('Não seleccionada (opcional)').val(0));
        $('#m_select2_area_especialidade_opcional').append($('<option>').text('Comunicações, Serviços e Infraestruturas').val(1));
        $('#m_select2_area_especialidade_opcional').append($('<option>').text('Engenharia de Software').val(2));
        $('#m_select2_area_especialidade_opcional').append($('<option>').text('Sistemas de Informação').val(3));
        $('#m_select2_area_especialidade_opcional').append($('<option>').text('Sistemas Inteligentes').val(4));

        consoleLog("preencheSelect2AreaEspecialidadeOpcional()");
    }




    var orientadorEmpresaDetalhesCallback = function() {

    }

    var orientadorEmpresaDetalhes = function(id) {
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/empresa/orientadores/select2listdetail/" + id,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                consoleLog('orientadorEmpresaDetalhes Received data:');
                consoleLog(data);
                //consoleLog($('#m_select2_orientadorempresa').find(':selected').val());

                $('input[name=torientadorempresa]').val(data[0].torientadorempresa);
                $('input[name=emailorientador]').val(data[0].emailorientador);
                $('input[name=telefoneorientador]').val(data[0].telefoneorientador);
                $('input[name=orientadorempresa]').val(data[0].orientadorempresa);
                $('input[name=funcaoorientador]').val(data[0].funcaoorientador);
                $('input[name=areaexperiencia]').val(data[0].areaexperiencia);
                $('input[name=areaeducacaoorientador]').val(data[0].areaeducacaoorientador);
                $('input[name=anosexperiencia]').val(data[0].anosexperiencia);
                $('input[name=anoeducacaoorientador]').val(data[0].anoeducacaoorientador);
                $('.cvorientadorempresa').html(data[0].cvorientadorempresa);
                $('input[name=cvorientadorempresa]').val(data[0].cvorientadorempresa);
                $('.cvorientadorempresa-file').attr('href', '/empresa/downloadcv/' + data[0].cvorientadorempresa);

                consoleLog(data[0].cvorientadorempresa);//cvorientadorempresa

                //grauorientador

                $('#m_grauorientador').val(data[0].grauorientador).trigger('change');

                //consoleLog($('#m_grauorientador option[value=8]<<'));
                //$('#m_grauorientador option[value=8]').prop('selected', true);

                orientadorEmpresaDetalhesCallback();
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    var cursoGetTitulo = function(tituloId) {
        $('input[name=curso]').val("loading...");

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/cursos/gettitulo/" + tituloId,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                $('.data-curso').html(data.titulo);
            },
            error: function(errMsg) {
                consoleLog(errMsg);
            }
        });
    }

    var loadData = function(estagioId) {
        consoleLog('estagioId : ', estagioId);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $('#m_select2_empresas_colaborador').select2().val(-1).trigger("change");
        $('#m_select2_empresas_representante').select2().val(-1).trigger("change");

        $.ajax({
            type: "POST",
            url: "/estagio/proposta/detalhe/" + estagioId,
            data: JSON.stringify(),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                CheckSession.check(data);
                consoleLog('Received data:');
                consoleLog(data.data);
                consoleLog('DOCENTE / autor_idautor:');
                consoleLog(data.data.autor_idautor);

                $('#m_select2_empresas').on('change', function() {
                    //consoleLog(this.value);
                    if(data.data.empresa_colaborador>=0) {
                        $('#m_select2_empresas_colaborador').select2().val(data.data.empresa_colaborador).trigger("change");
                    }
                    if(data.data.empresa_representantelegal>=0) {
                        $('#m_select2_empresas_representante').select2().val(data.data.empresa_representantelegal).trigger("change");
                    }
                });

                //alert(data.data.autor_idautor);

                //$('#m_select2_docentes').select2().val(data.data.autor_idautor).trigger("change");
                $('#m_select2_docentes').select2().val(data.data.autor_idautor).trigger("change");

                $('#m_select2_periodos_estagio').select2().val(data.data.periodo_estagio_idperiodo_estagio).trigger("change");

                $('#m_select2_area_especialidade').select2().val(data.data.opcaotematica).trigger("change");
                $('#m_select2_area_especialidade_opcional').select2().val(data.data.opcaotematica_opcional).trigger("change");

                //$('#m_grauorientador').select2().val(data.data.grauorientador).trigger('change');
                $('#m_grauorientador').val(data.data.grauorientador).trigger('change');

                consoleLog('EMPRESA');
                consoleLog(data.data.empresa_idempresa);
                $('#m_select2_empresas').select2().val(data.data.empresa_idempresa).trigger("change");
                //$('#m_select2_docentes').select2().val(116).trigger("change");

                /*setTimeout(function() {
                }, 3000);*/
            },
            error: function(errMsg) {
                //consoleLog(errMsg);
            }
        });
    }

    return {
        init: function() {
            init();

            consoleLog('profileType');
            consoleLog(profileType);


            datepickerFormat();
            preencheSelect2Docentes();
            preencheSelect2Empresas();
            preencheSelect2PeriodosEstagio();
            preencheSelect2OrientadorEmpresa();
            preencheSelect2AreaEspecialidade();
            preencheSelect2AreaEspecialidadeOpcional();
            initWidgets();

            //ESCONDE TODOS
            $('.inputs-curso').hide();
            //MOSTRA O NECESSÁRIO
            $('.inputs-curso-43').show();

            var idestagio =-1;

            if(estagioData) {
                idestagio = estagioData.idestagio;//$('input[name=idestagio]').val();
            }

            //alert(idestagio);

            if(idestagio>0) {
                loadData(idestagio);
            }

            if(profileType==2) {
                consoleLog("profileType 2");

                var idEmpresa = empresaData.idempresa;//$('input[name=idempresa]').val();

                consoleLog("empresa: " + idEmpresa);

                //if(idestagio) {//????????????????????
                if(idEmpresa) {
                    preencheSelect2EmpresaRepresentanteLegal(idEmpresa, function() {
                        if(estagioData.empresa_representantelegal) {
                            $('#m_select2_empresas_representante').select2().val(estagioData.empresa_representantelegal).trigger("change");
                        }
                    });
                    preencheSelect2EmpresaColaborador(idEmpresa, function() {
                        if(estagioData.empresa_colaborador) {
                            $('#m_select2_empresas_colaborador').select2().val(estagioData.empresa_colaborador).trigger("change");
                        }
                    });
                } else {
                    preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    preencheSelect2EmpresaColaborador(idEmpresa);
                }
            }

            setTimeout(function() {
            }, 5000);
        },
        rl: function (empresa) {
            preencheSelect2EmpresaRepresentanteLegal(empresa);
        },
        ca: function (empresa) {
            preencheSelect2EmpresaColaborador(empresa);
        }
    };
}();


jQuery(document).ready(function() {
    ThisFormControls.init();

    /*shortcut.add("Ctrl+Shift+1", function() {
        alert("F8 pressed");
    });*/
});