var ThisFormControls = function() {
    var init = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.m_form_selectpicker').selectpicker();

        $("input[name=estagio-titulo]").focusout(function(){
            formSaveOrUpdate();
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
                    console.log('Received data:');
                    console.log(data);
                    alert(data.message);

                    var idEmpresa = $('input[name=idempresa]').val();

                    preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    //preencheSelect2EmpresaColaborador(idEmpresa);
                },
                error: function(errMsg) {
                    //console.log(errMsg);
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
                    console.log('Received data:');
                    console.log(data);
                    alert(data.message);

                    var idEmpresa = $('input[name=idempresa]').val();

                    //preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
                    preencheSelect2EmpresaColaborador(idEmpresa);
                },
                error: function(errMsg) {
                    //console.log(errMsg);
                }
            });*/
        });
    };

    var changeSelect = function() {
        $("select.m-select2").select2({
            tags: true
        });
    };

    var formSaveOrUpdate = function() {
        console.log('formSaveOrUpdate');

        var id = $('input[name=idestagio]').val();

        if(id=='') {
            formSave();
        } else {
            formUpdate();
        }

        console.log(id);
    }

    var formSave = function() {
        console.log('formSave');

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

        console.log('formData: [');
        console.log(myData);
        console.log(']');

        //$('input[name=idestagio]').val(99);

        //$('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/estagios/propostas/savedata",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                //alert('123');
                console.log(':: data: [');
                console.log(data);
                console.log(']');

                console.log(':: result: [');
                console.log(data.result);
                console.log(']');

                if(data.result) {
                    toastr.success(data.message, 'Estagio');

                    $('#maintab_2').trigger('click');
                } else {
                    toastr.error(data.message, 'Estagio');
                }

                $('input[name=idestagio]').val(data.idestagio);
                /*$('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });*/
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });

        //toastr.success('Dados do estágio guardados', 'Estagio');
    }

    var formUpdate = function() {
        console.log('formUpdate');

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

        console.log('formData: [');
        console.log(myData);
        console.log(']');

        //$('input[name=idestagio]').val(99);

        //$('input[name=idempresa]').val(idEmpresa);

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        $.ajax({
            type: "POST",
            url: "/estagios/propostas/savedata",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                alert('123');
                console.log(':: data: [');
                console.log(data);
                console.log(']');

                console.log(':: result: [');
                console.log(data.result);
                console.log(']');

                if(data.result) {
                    toastr.success(data.message, 'Estagio');
                } else {
                    toastr.error(data.message, 'Estagio');
                }

                $('input[name=idestagio]').val(data.idestagio);
                /*$('#m_select2_empresas_colaborador').find('option').remove();

                $('#m_select2_empresas_colaborador').append($('<option>').text('Seleccione o contacto administrativo da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_colaborador').append($('<option>').text(value.nome).val(value.id));
                });*/
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });

        //toastr.success('Dados do estágio guardados', 'Estagio');
    }

    //== Private functions
    //var validator;

    var initWidgets = function() {
        // select2
        $('#m_select2_docentes').select2({
            placeholder: "Selecione um docente",
            width: 'resolve',
        });

        $('#m_select2_empresas').select2({
            placeholder: "Selecione uma instituição",
            width: 'resolve',
        });

        $('#m_select2_periodos_estagio').select2({
            placeholder: "Selecione um período de estágio",
            width: 'resolve',
        });

        $('#m_select2_orientadorempresa').select2({
            placeholder: "Selecione um orientador na empresa",
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

            console.log('changed');

            var docente = $('#m_select2_docentes').select2('data');
            console.log(docente);
        });

        $('#m_select2_docentes').on('change', function(){
            console.log(this.value);
        });

        $('#m_select2_empresas').on('change', function(){
            var idEmpresa = this.value;
            preencheSelect2EmpresaRepresentanteLegal(idEmpresa);
            preencheSelect2EmpresaColaborador(idEmpresa);
        });
    }

    var preencheSelect2EmpresaColaborador = function(idEmpresa) {
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

    var preencheSelect2EmpresaRepresentanteLegal = function(idEmpresa) {
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
                $('#m_select2_empresas_representante').find('option').remove();

                $('#m_select2_empresas_representante').append($('<option>').text('Seleccione o representante legal da empresa').val(-1));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas_representante').append($('<option>').text(value.nome).val(value.id));
                });
            },
            error: function(errMsg) {
                //console.log(errMsg);
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
                //console.log('Received data:');
                //console.log(data);
                //$('#m_select2_docentes').html('');

                $.each(data, function(index, value) {
                    $('#m_select2_docentes').append($('<option>').text(value.nome).val(value.id));
                });

                initWidgetsCallbacks();
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
    }

    var preencheSelect2Empresas = function() {
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
                //console.log('Received data:');
                //console.log(data);
                //$('#m_select2_empresas').html('');

                $('#m_select2_empresas').find('option').remove();

                $('#m_select2_empresas').append($('<option>').text('Seleccione a empresa').val(-1).attr('disabled', 'disabled'));

                $.each(data, function(index, value) {
                    $('#m_select2_empresas').append($('<option>').text(value.nome).val(value.id));
                });

                initWidgetsCallbacks();
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
    }

    var preencheSelect2PeriodosEstagioCallback = function() {
        $('#m_select2_periodos_estagio').on('change', function(){
            cursoGetTitulo(this.value, function (title) {
                $('input[name=curso]').val(title);
            });
        });

        if($('#m_select2_periodos_estagio')!= "undefined") {
            var theVal = $('#m_select2_periodos_estagio').val();

            if (typeof (theVal) == "undefined") {
                theVal = $('.estagio-info-curso').html();
                console.log(theVal);
            }

            cursoGetTitulo(theVal, function (title) {
                $('.estagio-info-curso').html(title);
            });
        }
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
                //console.log('Received data:');
                //console.log(data);
                //$('#m_select2_periodos_estagio').html('');

                $.each(data, function(index, value) {
                    $('#m_select2_periodos_estagio').append($('<option>').text(value.descricao).val(value.id));
                });

                preencheSelect2PeriodosEstagioCallback();
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
    }

    var preencheSelect2OrientadorEmpresaCallback = function() {
        $('#m_select2_orientadorempresa').on('change', function(){
            //console.log(this.attr('info'));
            console.log(this);
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
                //console.log('Received data:');
                //console.log(data);
                //$('#m_select2_periodos_estagio').html('');

                $.each(data, function(index, value) {
                    //$('#m_select2_orientadorempresa').append($('<option>').text(value.orientadorempresa).val(value.idestagio).attr('info',20));
                    $('#m_select2_orientadorempresa').append($('<option>').text(value.orientadorempresa).val(value.idestagio));
                });

                preencheSelect2OrientadorEmpresaCallback();
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
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
                console.log('orientadorEmpresaDetalhes Received data:');
                console.log(data);
                //console.log($('#m_select2_orientadorempresa').find(':selected').val());

                $('input[name=torientadorempresa]').val(data[0].torientadorempresa);
                $('input[name=emailorientador]').val(data[0].emailorientador);
                $('input[name=telefoneorientador]').val(data[0].telefoneorientador);
                $('input[name=nomeorientador]').val(data[0].orientadorempresa);
                $('input[name=funcaoorientador]').val(data[0].funcaoorientador);
                $('input[name=areaexperiencia]').val(data[0].areaexperiencia);
                $('input[name=areaeducacaoorientador]').val(data[0].areaeducacaoorientador);
                $('input[name=anosexperiencia]').val(data[0].anosexperiencia);
                $('input[name=anoeducacaoorientador]').val(data[0].anoeducacaoorientador);

                //grauorientador

                $('#m_grauorientador').val(data[0].grauorientador).trigger('change');

                //console.log($('#m_grauorientador option[value=8]<<'));
                //$('#m_grauorientador option[value=8]').prop('selected', true);

                orientadorEmpresaDetalhesCallback();
            },
            error: function(errMsg) {
                //console.log(errMsg);
            }
        });
    }

    var cursoGetTitulo = function(tituloId, callbackFunction) {
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
                callbackFunction(data.titulo);
            },
            error: function(errMsg) {
                console.log(errMsg);
            }
        });
    }

    var initCandidaturas = function() {
        $(document.body).on('change','select.selectPerfilAdequado',function(){
            console.log($(this).attr('data-aluno') + " " + $(this).find(":selected").val());

            var estagioId = $('.estagio-info').html();
            var alunoId = $(this).attr('data-aluno');
            var estadoPerfil = $(this).find(":selected").val();

            $.ajax({
                type: "POST",
                url: "/estagios/propostas/setperfil/" + estagioId + "/" + alunoId + "/" + estadoPerfil,
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    //console.log(data.success);
                    if(data.success == 1) {
                        toastr.success(data.message, 'Perfil de estágio');
                    } else {
                        toastr.error(data.message, 'Perfil de estágio');
                    }
                },
                error: function(errMsg) {
                    console.log(errMsg);
                }
            });

        });
    };

    return {
        init: function() {
            init();
            initCandidaturas();
            datepickerFormat();
            preencheSelect2Docentes();
            preencheSelect2Empresas();
            preencheSelect2PeriodosEstagio();
            preencheSelect2OrientadorEmpresa();
            initWidgets();
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
});