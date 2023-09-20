var AppDashboard = function() {
    var init = function() {
        $.ajax({
            type: "GET",
            url: "/queries/rpua",
            // The key needs to match your method's input parameter (case-sensitive).
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);

                var container = $('#rp_model-2').parent();
                var toClone = $('#rp_model-2').clone();
                $('#rp_model-2').remove();

                $.each( data, function(i, item ) {
                    //console.log( data[i]);
                    console.log( item.anexo);
                    var element = $(toClone).clone();
                    $(element).find('.data-id').html(item.idrelatorio);
                    $(element).find('.data-data').html(item.created);
                    $(element).find('.data-aluno').html(item.alunoatribuido);
                    $(element).find('.data-titulo').html(item.tituloestagio);
                    $(element).find('.data-orientador').html(item.orientadorDEI);
                    $(element).find('.data-relatorio > .data-anexo-link').attr("href", '/queries/rpdownload/' + item.idrelatorio);
                    //$(element).find('.data-relatorio > .data-anexo-link').attr("href", '/estagios/propostas/edita/' + item.idrelatorio);
                    //$(element).find('.anexo-link').attr("href", '/queries/rpdownload/' + item.idrelatorio);
                    $(container).append(element)
                });

                },
            error: function(errMsg) {
                //alert(errMsg);
            }
        });

        $.ajax({
            type: "GET",
            url: "/queries/ur",
            // The key needs to match your method's input parameter (case-sensitive).
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);

                var container = $('#rp_model-3').parent();
                var toClone = $('#rp_model-3').clone();
                $('#rp_model-3').remove();

                $.each( data, function(i, item ) {
                    //console.log( data[i]);
                    console.log( item);
                    var element = $(toClone).clone();
                    $(element).find('.data-id').html(item.idrelatorio);
                    $(element).find('.data-data').html(item.created);
                    $(element).find('.data-aluno').html(item.alunoatribuido);
                    $(element).find('.data-titulo').html(item.tituloestagio);
                    $(element).find('.data-orientador').html(item.orientadorDEI);
                    $(element).find('.data-relatorio > .data-anexo-link').attr("href", '/queries/rpdownload/' + item.idrelatorio);
                    //$(element).find('.data-relatorio > .data-anexo-link').attr("href", '/estagios/propostas/edita/' + item.idrelatorio);
                    //$(element).find('.anexo-link').attr("href", '/queries/rpdownload/' + item.idrelatorio);
                    $(container).append(element)
                });

            },
            error: function(errMsg) {
                //alert(errMsg);
            }
        });

        $.ajax({
            type: "GET",
            url: "/queries/nre",
            // The key needs to match your method's input parameter (case-sensitive).
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);

                var container = $('#rp_model-4').parent();
                var toClone = $('#rp_model-4').clone();
                $('#rp_model-4').remove();

                $.each( data, function(i, item ) {
                    //console.log( data[i]);
                    console.log( item);
                    var element = $(toClone).clone();
                    $(element).find('.data-id').html(item.idestagio);
                    $(element).find('.data-curso').html(item.curso);
                    $(element).find('.data-titulo').html(item.tituloestagio);
                    $(element).find('.data-nreunioes').html(item.nreunioes);
                    $(container).append(element)
                });

            },
            error: function(errMsg) {
                //alert(errMsg);
            }
        });

        $.ajax({
            type: "GET",
            url: "/queries/info",
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.estagios-info-nalunos').html(data.nalunos);
                $('.estagios-info-nrelatoriosprogresso').html(data.nrelatoriosp);

                var i=0;
                $('.estagios-info-nreunioes-mes-1-titulo').html('Reuniões em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-1-subtitulo').html('Reuniões realizadas em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-1-quantidade').html(data.nreunioesmes[i].qtd);
                i++;

                $('.estagios-info-nreunioes-mes-2-titulo').html('Reuniões em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-2-subtitulo').html('Reuniões realizadas em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-2-quantidade').html(data.nreunioesmes[i].qtd);
                i++;

                $('.estagios-info-nreunioes-mes-3-titulo').html('Reuniões em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-3-subtitulo').html('Reuniões realizadas em ' + data.nreunioesmes[i].mes);
                $('.estagios-info-nreunioes-mes-3-quantidade').html(data.nreunioesmes[i].qtd);
                i++;

                i=0;
                $('.data-curso-1-titulo').html(data.nestagioscurso[i].curso);
                $('.data-curso-1-subtitulo').html("número de alunos inscritos");
                $('.data-curso-1-valor').html(data.nestagioscurso[i].counter);
                $('.data-curso-1-percentagem').html(data.nestagioscurso[i].percentagem + '%');
                i++;

                $('.data-curso-2-titulo').html(data.nestagioscurso[i].curso);
                $('.data-curso-2-subtitulo').html("número de alunos inscritos");
                $('.data-curso-2-valor').html(data.nestagioscurso[i].counter);
                $('.data-curso-2-percentagem').html(data.nestagioscurso[i].percentagem + '%');
                i++;

                $('.data-curso-3-titulo').html(data.nestagioscurso[i].curso);
                $('.data-curso-3-subtitulo').html("número de alunos inscritos");
                $('.data-curso-3-valor').html(data.nestagioscurso[i].counter);
                $('.data-curso-3-percentagem').html(data.nestagioscurso[i].percentagem + '%');
                i++;

                $('.data-curso-4-titulo').html(data.nestagioscurso[i].curso);
                $('.data-curso-4-subtitulo').html("número de alunos inscritos");
                $('.data-curso-4-valor').html(data.nestagioscurso[i].counter);
                $('.data-curso-4-percentagem').html(data.nestagioscurso[i].percentagem + '%');
                i++;


            },
            error: function(errMsg) {
                //alert(errMsg);
            }
        });



        //estagios-info-nalunos
    };

    return {
        init: function() {
            //init();

            $('#btnNovoColaboradorSave').click(function(){
                var x = $("#novoElementoForm").serializeArray();
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
                    },
                    error: function(errMsg) {
                        //console.log(errMsg);
                    }
                });
            });

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
                    },
                    error: function(errMsg) {
                        //console.log(errMsg);
                    }
                });
            });

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "20000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }
    };
}();


jQuery(document).ready(function() {
    AppDashboard.init();
});