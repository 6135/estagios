var AppDashboard = function() {
    var init = function() {
        $('.btn_action_email_empresa').click(function() {
            $.get( "/testing/emails/empresa", { tipo: "e" }, function( data ) {
                console.log( data );
                alert(data.message);
            }, "json");
        });

        $('.btn_action_email_aluno').click(function() {
            $.get( "/testing/emails/aluno", { tipo: "a" }, function( data ) {
                console.log( data );
                alert(data.message);
            }, "json");
        });

        $('.btn_action_email_docente').click(function() {
            $.get( "/testing/emails/docente", { tipo: "d" }, function( data ) {
                console.log( data );
                alert(data.message);
            }, "json");
        });

        $('#m_aside_left_minimize_toggle').click(function() {
            $.get( "/environment/leftmenumin/", {}, function( data ) {
                console.log( data );
                alert(data.message);
            }, "json");
        });
    };

    return {
        init: function() {
            init();

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

            setTimeout(function() {
                //toastr.info("Inconceivable!");
            }, 1500);}
    };
}();


jQuery(document).ready(function() {
    AppDashboard.init();
});