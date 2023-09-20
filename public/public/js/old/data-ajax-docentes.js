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
                        url: '/docentes/lista/json',
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

            search: {
                input: $('#generalSearch'),
            },

            // columns definition
            columns: [
                {
                    field: 'iddocente',
                    title: 'Id',
                    //sortable: false, // disable sort for this column
                    width: 20,
                    selector: false,
                    textAlign: 'center',
                }, {
                    field: 'logindocente',
                    title: 'Login',
                    // sortable: 'asc', // default sort
                    filterable: false, // disable or enable filtering
                    width: 60,
                    // basic templating support for column rendering,
                    //template: '{{OrderID}} - {{ShipCountry}}',
                }, {
                    field: 'Activo',
                    title: 'activo',
                    // callback function support for column rendering
                    template: function (row) {
                        var status = {
                            1: {'title': 'Sim', 'class': ' m-badge--success', 'value': 'checked="checked"'},
                            0: {'title': 'Não', 'class': ' m-badge--danger', 'value': ''},
                        };

                        //alert('update');

                        var activo=0;

                        if(status[row.activo] != undefined) {
                            if(status[row.activo].value != undefined) {
                                activo = status[row.activo].value;
                            }
                        } else {
                            console.log('DB: erro nas migrations, falta campo activo nos docentes');
                            console.log('DB: executar: php artisan migrate:fresh');
                        }

                        return '<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand switch-user-isadmin"><label><input type="checkbox" ' + activo + ' name="" userId="' + row.id + '"><span></span></label></span>';

                        /*var status = {
                            1: {'title': 'Sim', 'class': ' m-badge--success'},
                            0: {'title': 'Não', 'class': ' m-badge--danger'},
                        };*/

                        //return '<span class="m-badge ' + status[row.isAdmin].class + ' m-badge--wide">' + status[row.isAdmin].title + '</span>';
                    },
                }, {
                    field: 'nomedocente',
                    title: 'Nome',
                    width: 250,
                    //template: function(row) {
                    // callback function support for column rendering
                    //return row.ShipCountry + ' - ' + row.ShipCity;
                    //},
                }, {
                    field: 'num_mecanografico',
                    title: 'Numero Mecanografico',
                    width: 200,
                }, {
                    field: 'created',
                    title: 'Data de registo',
                    type: 'date',
                    format: 'DD/MM/YYYY',
                    width: 110,
                }, {
                    field: 'Actions',
                    width: 110,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    template: function (row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                        return '<a href="/docentes/edita/' + row.iddocente + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar dados">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill button_action_empresa_delete" title="Delete">\
							<i class="la la-trash"></i>\
						</a>';
                    },
                }],
        });

        $('#m_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#m_form_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $(datatable).on('dataload', function() {
            alert('111');
            $('.button_action_empresa_delete').click(function(){
                alert('222');
                //console.log('teste.....');
                //bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });
            });
        });

        $('#m_form_status, #m_form_type').selectpicker();
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