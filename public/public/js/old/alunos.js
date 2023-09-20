var AppAlunos = function() {
    var init = function() {
        $( "select" ).each(function( index ) {
            var valorSelect = $( this ).attr('value');
            $( this ).val(valorSelect);
        });

        $('.selectpicker').selectpicker('refresh')

        $('select[name=select_doc_identificacao]').on('change', function() {
            updateDocIdentFields(this.value);
        });
    };

    var updateDocIdentFields = function(doctype) {
        switch(this.value) {
            case 'BI':
                $('.form-group-cartao-cidadao').hide('slow');
                $('.form-group-bi').show('slow');
                $('.form-group-passaporte').hide('slow');
                break;
            case 'CC':
                $('.form-group-cartao-cidadao').show('slow');
                $('.form-group-bi').hide('slow');
                $('.form-group-passaporte').hide('slow');
                break;
            case 'PP':
                $('.form-group-cartao-cidadao').hide('slow');
                $('.form-group-bi').hide('slow');
                $('.form-group-passaporte').show('slow');
                break;
        }
    }

    return {
        init: function() {
            init();
        }
    };
}();


jQuery(document).ready(function() {
    AppAlunos.init();
});