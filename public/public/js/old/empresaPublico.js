var EmpresaPublico = function() {
    var init = function() {

    };

    var validaNif = function(contribuinte) {
        var temErro=0;

        if (
            contribuinte.substr(0,1) != '1' && // pessoa singular
            contribuinte.substr(0,1) != '2' && // pessoa singular
            contribuinte.substr(0,1) != '3' && // pessoa singular
            contribuinte.substr(0,2) != '45' && // pessoa singular não residente
            contribuinte.substr(0,1) != '5' && // pessoa colectiva
            contribuinte.substr(0,1) != '6' && // administração pública
            contribuinte.substr(0,2) != '70' && // herança indivisa
            contribuinte.substr(0,2) != '71' && // pessoa colectiva não residente
            contribuinte.substr(0,2) != '72' && // fundos de investimento
            contribuinte.substr(0,2) != '77' && // atribuição oficiosa
            contribuinte.substr(0,2) != '79' && // regime excepcional
            contribuinte.substr(0,1) != '8' && // empresário em nome individual (extinto)
            contribuinte.substr(0,2) != '90' && // condominios e sociedades irregulares
            contribuinte.substr(0,2) != '91' && // condominios e sociedades irregulares
            contribuinte.substr(0,2) != '98' && // não residentes
            contribuinte.substr(0,2) != '99' // sociedades civis

        ) {
            temErro=1; //no!
        }

        var check1 = contribuinte.substr(0,1)*9;
        var check2 = contribuinte.substr(1,1)*8;
        var check3 = contribuinte.substr(2,1)*7;
        var check4 = contribuinte.substr(3,1)*6;
        var check5 = contribuinte.substr(4,1)*5;
        var check6 = contribuinte.substr(5,1)*4;
        var check7 = contribuinte.substr(6,1)*3;
        var check8 = contribuinte.substr(7,1)*2;

        var total= check1 + check2 + check3 + check4 + check5 + check6 + check7 + check8;
        var divisao= total / 11;
        var modulo11=total - parseInt(divisao)*11;
        if ( modulo11==1 || modulo11==0){ comparador=0; } // excepção
        else { comparador= 11-modulo11;}


        var ultimoDigito=contribuinte.substr(8,1)*1;
        if ( ultimoDigito != comparador ){ temErro=1;}


        //EXCEPCAO PARA CONTRIBUINTES ESTRANGEIROS
        if(isNaN(contribuinte.substr(0,2))) {
            temErro=0;
        }

        return temErro;
    };

    var dadosEmpresa = function() {
        $('button[name=validar]').click(function(event){
            event.preventDefault();

            if(validateData()==0) {
                // console.log('data valid');
            }
        });

        $('button[name=savedata]').click(function(event) {
            event.preventDefault();

            if(validateData()==0) {
                saveData();
                // console.log('data valid');
            }
        });
    };

    var initWidgets = function() {
        // select2
        $('#m_select2_empresas').select2({
            placeholder: "Selecione uma instituição",
            width: 'resolve',
        });
    }

    var preencheSelect2Empresas = function() {
        if($('#m_select2_empresas').length > 0 ) {

            console.log('preencheSelect2Empresas');

            $.ajax({
                type: "POST",
                url: "/empresa/select2List",
                //data: {nif: nif},
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    console.log('Received data:');
                    console.log(data);
                    //$('#m_select2_empresas').html('');

                    $('#m_select2_empresas').find('option').remove();

                    $('#m_select2_empresas').append($('<option>').text('Seleccione a empresa').val(-1).attr('disabled', 'disabled'));

                    $.each(data, function (index, value) {
                        $('#m_select2_empresas').append($('<option>').text(value.nome).val(value.id));
                    });

                    //initWidgetsCallbacks();
                },
                error: function (errMsg) {
                    console.log(errMsg);
                }
            });
        }
    }

    var validateData = function() {
        var erro = 0;

        var nif = $('input[name=nif]').val();

        if(validaNif(nif)==1) {
            toastr.error('O número de contribuinte está incorreto.', 'NIF');
            console.log('O número de contribuinte está incorreto.');
            erro = 1;
        }else {
        }

        var formData = new Object();
        formData.email = $('input[name=email]').val();
        formData.password1 = $('input[name=password1]').val();
        formData.password2 = $('input[name=password2]').val();
        formData.nif = $('input[name=nif]').val();

        if(formData.password1 != formData.password2) {
            toastr.error('Verifique o campo das passwords', 'Passwords');
            console.log('Verifique o campo das passwords');
            erro = 1;
        }

        return erro;
    };

    var saveData = function() {
        var formData = new Object();
        formData.email = $('input[name=email]').val();
        formData.password1 = $('input[name=password1]').val();
        formData.password2 = $('input[name=password2]').val();
        formData.nif = $('input[name=nif]').val();

        /*console.log("formData:");
        console.log(formData);*/

        $('button[name=savedata]').prop("disabled", true);

        $.ajax({
            type: "POST",
            url: "/empresa/novoregisto",
            data: JSON.stringify(formData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                /*console.log(data);
                console.log(data.message);
                console.log(data.result);
                console.log("hello");*/

                if(data.result) {
                    toastr.success(data.message, '');
                    //app.url/

                    setTimeout(function(){
                        //window.location.replace(app.url/);
                        window.location.replace("/message/checkmail");
                    }, 3000);
                } else {
                    $('button[name=savedata]').prop("disabled", false);
                    toastr.error(data.message, '');
                }
            },
            error: function(errMsg) {
                $('button[name=savedata]').prop("disabled", false);
                //alert(errMsg);
            }
        });
    };

    var saveDatafASE2 = function() {
        var formData = new Object();

        //alert('saveDatafASE2');


        formData.nome = $('input[name=nome]').val();
        formData.acronimo = $('input[name=acronimo]').val();
        //formData.nif = $('input[name=nif]').val();//readonly
        formData.actividade = $('#actividadeEmpresa').val();
        formData.sede = $('input[name=sede]').val();
        formData.url = $('input[name=url]').val();
        //formData.email = $('input[name=email]').val();//readonly
        formData.telefone = $('input[name=telefone]').val();

        formData.rltitulo = $('input[name=rl-titulo]').val();
        formData.rlnome = $('input[name=rl-nome]').val();
        formData.rlcargo = $('input[name=rl-cargo]').val();
        formData.rlemail = $('input[name=rl-email]').val();
        //formData.empresa = $('select[name=select2_empresas]').val();

        formData.token = $('input[name=token]').val();

        formData.declaracao = $('input[name=declaracao]').prop("checked");
        console.log(formData.declaracao);

        //formData.declaracao = $('input[name=declaracao]').val();

        console.log("formData:");
        console.log(formData);
        //console.log($('input').val());

        if(formData.declaracao) {
            $('button[name=savedata]').prop("disabled", true);

            $.ajax({
                type: "POST",
                url: "/empresa/registopublico-fase2-save",
                data: JSON.stringify(formData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    console.log(data.message);
                    console.log(data.result);

                    if (data.result) {
                        toastr.success(data.message, '');

                        //app.url/
                        setTimeout(function () {
                            window.location.replace(app.url);
                        }, 5000);
                    } else {
                        $('button[name=savedata]').prop("disabled", false);
                        console.log("smth weird happened")
                        toastr.error(data.message, '');
                    }
                },
                error: function (errMsg) {
                    $('button[name=savedata]').prop("disabled", false);
                    console.log('failed');
                    toastr.error(errMsg, '');
                }
            });
        }else {
            toastr.error('Tem de declarar a validade da informação', '');
        }
    };

    var saveDatafASE2TipoA = function() {
        //1-empresa-encontrada
        var x = $("#empresaForm").serializeArray();
        var myData = new Object();

        $.each(x, function(i, field){
            myData[field.name] = field.value;
        });

        console.log(myData);

        $('button[name=savedata]').prop("disabled", true);

        $.ajax({
            type: "POST",
            url: "/empresa/registopublico-fase22-save",
            data: JSON.stringify(myData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                //console.log(data.message);
                //console.log(data.result);

                if (data.result) {
                    toastr.success(data.message, '');

                    //app.url/
                    /*setTimeout(function () {
                        window.location.replace(app.url/);
                    }, 5000);*/
                } else {
                    $('button[name=savedata]').prop("disabled", false);

                    toastr.error(data.message, '');
                }
            },
            error: function (errMsg) {
                $('button[name=savedata]').prop("disabled", false);

                toastr.error(errMsg, '');
            }
        });
    }

    var dadosEmpresaFase2 = function() {
        initWidgets();

        preencheSelect2Empresas();

        var tipoForm = $('input[name=formtype]').val();

        if(tipoForm=='1-empresa-encontrada') {
            $('button[name=savedata]').click(function(event) {
                event.preventDefault();
                let var23 = $('#empresaForm').get(0).reportValidity();
                if(var23)
                    saveDatafASE2TipoA();
            });
        } else {
            $('button[name=savedata]').click(function(event) {
                event.preventDefault();
                let var23 = $('#empresaForm').get(0).reportValidity();
                // console.log("var3 ");
                if(var23)
                    saveDatafASE2();
            });
        }
    };

    return {
        init: function() {
            console.log('init');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        dadosEmpresa: function() {
            dadosEmpresa();
        },
        dadosEmpresaFase2: function() {
            dadosEmpresaFase2();
        }
    };
}();


jQuery(document).ready(function() {
    EmpresaPublico.init();
});