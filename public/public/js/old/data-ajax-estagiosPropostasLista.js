//== Class definition

var DatatableRemoteAjaxDemo = function() {
    //== Private functions

    // basic demo
    var demo = function() {
        var datatable = $('.m_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        // sample GET method
                        method: 'GET',
                        url: '/estagios/propostas/lista/json/',
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 100,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false
            },

            // column sorting
            sortable: true,

            pagination: true,

            toolbar: {
                // toolbar items
                items: {
                    // pagination
                    pagination: {
                        // page size select
                        pageSizeSelect: [10, 20, 30, 50, 100],
                    },
                },
            },

            /*search: {
                input: $('#generalSearch'),
            },*/

            // columns definition
            columns: [
                {
                    field: 'idestagio',
                    title: 'Num',
                    //sortable: true, // disable sort for this column
                    width: 100,
                    //selector: false,
                    textAlign: 'center',
                }, {
                    field: 'empresaestagio',
                    title: 'Instituição',
                    // sortable: 'asc', // default sort
                    filterable: false, // disable or enable filtering
                    width: 400,
                    // basic templating support for column rendering,
                    //template: '{{OrderID}} - {{ShipCountry}}',
                }, {
                    field: 'empresa.idempresa',
                    title: 'empresa.idempresa',
                    filterable: false, // disable or enable filtering
                    width: 80,
                }, {
                    field: 'tituloestagio',
                    title: 'Título',
                    filterable: false,
                    width: 400,
                }, {
                    field: 'empresa.nomeempresa',
                    title: 'Título2',
                    filterable: false,
                    width: 400,
                }, {
                    field: 'areatecnologica',
                    title: 'Area',
                    filterable: false,
                    width: 400,
                }, {
                    field: 'Actions',
                    width: 60,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    template: function (row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                        return '<a href="/estagios/propostas/edita/' + row.idestagio + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar dados">\
							<i class="la la-edit"></i>\
						</a>';
                    },
                }],
        });

        /*var query = datatable.getDataSourceQuery();

        $('#m_form_status').on('change', function () {
            datatable.search($(this).val(), 'Status');
        }).val(typeof query.Status !== 'undefined' ? query.Status : '');*/

        //m_form_instituicao
        $('#m_form_instituicao').on('change', function() {
            //datatable.search($(this).val(), 'curso');
            //alert($(this).val());
            //datatable.search($(this).val().toString(), 'empresaidempresa');
            //datatable.search($(this).val().toString());

            datatable.search($(this).val(), 'empresa.idempresa');
            //datatable.search($(this).val(), 'idempresa');

            //datatable.search(1, 'empresaidempresa');
            //datatable.search($(this).val());
            //column(3).search(8).draw();
        });

        /*$('#m_form_status').on('change', function() {
            //datatable.search($(this).val(), 'curso');
            datatable.search($(this).val());
        });*/

        /*$('#m_form_instituicao').on('change', function() {
            //alert($(this).attr('valuetitle'));
            console.log($(this).val());
            //datatable.search($(this).val().toLowerCase(), 'empresaestagio');
            //datatable.search('99');
        });*/

        $(datatable).on('dataload', function() {
            alert('111');
            $('.button_action_empresa_delete').click(function(){
                alert('222');
                //console.log('teste.....');
                //bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });
            });
        });

        //$('#m_form_status, #m_form_type').selectpicker();
        $('.m_form_selectpicker').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();

            /*setTimeout(function() {
                $('.button_action_empresa_delete').click(function() {
                    alert('...');
                    //console.log('teste.....');
                    bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });
                });
            }, 3000);*/
        },
    };
}();

var DatatableActions = function() {
    var deleteRow = function() {
        $('.button_action_empresa_delete').on('click', function() {
            alert('Apagar?');
            //console.log('teste.....');
            bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });
        });
    };

    return {
        init: function() {
            setTimeout(function() {
                deleteRow();
            }, 1500);
        }
    };
}();


jQuery(document).ready(function() {
    DatatableRemoteAjaxDemo.init();
    DatatableActions.init();
});