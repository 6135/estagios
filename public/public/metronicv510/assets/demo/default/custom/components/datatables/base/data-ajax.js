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
                        url: '/listaempresas/',
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
                    field: 'idempresa',
                    title: 'Id',
                    //sortable: false, // disable sort for this column
                    width: 20,
                    selector: false,
                    textAlign: 'center',
                }, {
                    field: 'acronimoempresa',
                    title: 'Acrónimo',
                    // sortable: 'asc', // default sort
                    filterable: false, // disable or enable filtering
                    width: 60,
                    // basic templating support for column rendering,
                    //template: '{{OrderID}} - {{ShipCountry}}',
                }, {
                    field: 'nomeempresa',
                    title: 'Nome',
                    width: 250,
                    //template: function(row) {
                    // callback function support for column rendering
                    //return row.ShipCountry + ' - ' + row.ShipCity;
                    //},
                }, {
                    field: 'emailempresa',
                    title: 'Email',
                    width: 200,
                }, {
                    field: 'telefoneempresa',
                    title: 'Telefone',
                    width: 110,
                }, {
                    field: 'created',
                    title: 'Data de registo',
                    type: 'date',
                    format: 'DD/MM/YYYY',
                    width: 110,
                }, {
                    /*field: 'Latitude',
                    title: 'Latitude',
                    type: 'number',
                  }, {
                    field: 'Status',
                    title: 'Status',
                    // callback function support for column rendering
                    template: function(row) {
                      var status = {
                        1: {'title': 'Pending', 'class': 'm-badge--brand'},
                        2: {'title': 'Delivered', 'class': ' m-badge--metal'},
                        3: {'title': 'Canceled', 'class': ' m-badge--primary'},
                        4: {'title': 'Success', 'class': ' m-badge--success'},
                        5: {'title': 'Info', 'class': ' m-badge--info'},
                        6: {'title': 'Danger', 'class': ' m-badge--danger'},
                        7: {'title': 'Warning', 'class': ' m-badge--warning'},
                      };
                      //return '<span class="m-badge ' + status[row.Status].class + ' m-badge--wide">' + status[row.Status].title + '</span>';
                        return '<span class="m-badge m-badge--wide">0</span>';
                    },
                  }, {
                    field: 'Type',
                    title: 'Type',
                    // callback function support for column rendering
                    template: function(row) {
                      var status = {
                        1: {'title': 'Online', 'state': 'danger'},
                        2: {'title': 'Retail', 'state': 'primary'},
                        3: {'title': 'Direct', 'state': 'accent'},
                      };
                        //return '<span class="m-badge m-badge--' + status[row.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.Type].state + '">' +
                            //status[row.Type].title + '</span>';
                        return '<span class="m-badge m-badge--dot"></span>&nbsp;<span class="m--font-bold">0</span>';
                    },
                  }, {*/
                    field: 'Actions',
                    width: 110,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    template: function (row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                        return '<a href="/mv51forms/' + row.idempresa + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar dados">\
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