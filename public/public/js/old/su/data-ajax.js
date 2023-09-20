//== Class definition

var DatatableChildRemoteDataDemo = function() {
  //== Private functions

  // demo initializer
  var demo = function() {

    var datatable = $('.m_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: '/su/candidatos-dados-ajax',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          },
        },
        pageSize: 10, // display 20 records per page
        serverPaging: true,
        serverFiltering: false,
        serverSorting: true,
      },

      // layout definition
      layout: {
        theme: 'default',
        scroll: false,
        height: null,
        footer: false,
      },

      // column sorting
      sortable: true,

      pagination: true,

      detail: {
        title: 'Load sub table',
        content: subTableInit,
      },

      search: {
        input: $('#generalSearch'),
      },

      // columns definition
      columns: [
        {
          field: 'idestagio',
          title: '',
          sortable: false,
          width: 20,
          textAlign: 'center',
        }, {
          field: 'checkbox',
          title: '',
          template: '{{idestagio}}',
          sortable: false,
          width: 20,
          textAlign: 'center',
          selector: {class: 'm-checkbox--solid m-checkbox--brand'},
        }, {
          field: 'title',
          title: 'Título',
          sortable: 'asc',
          width: 600,
          // responsive: {hidden: 'md'}
        }, {
          field: 'company',
          title: 'Company',
        }, {
          field: 'email',
          title: 'Email',
        }, {
          field: 'phone',
          title: 'telefone',
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
            /*return '<span class="m-badge ' + status[row.Status].class + ' m-badge--wide">' + status[row.Status].title + '</span>';*/
            return '<span class="m-badge m-badge--success m-badge--wide">sdfsdfsdf</span>';
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
            /*return '<span class="m-badge m-badge--' + status[row.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.Type].state + '">' +*/
            return '<span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-Retail"></span>';
          },
        }, {
          field: 'Actions',
          width: 110,
          title: 'Actions',
          sortable: false,
          overflow: 'visible',
          template: function (row, index, datatable) {
            var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
            return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
						  	</div>\
						</div>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
          },
        }],
    });

    function subTableInit(e) {
      console.log(e.data.idestagio);
      console.log($('<div/>').attr('id', 'child_data_ajax_' + e.data.idestagio));

      $('<div/>').attr('id', 'child_data_ajax_' + e.data.idestagio).appendTo(e.detailCell).mDatatable({
        data: {
          type: 'remote',
          source: {
            read: {
              url: '/su/candidatos/detalhe',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              params: {
                // custom query params
                query: {
                  generalSearch: '',
                  CustomerID: e.data.idestagio,
                },
              },
            },
          },
          pageSize: 10,
          serverPaging: true,
          serverFiltering: false,
          serverSorting: true,
        },

        // layout definition
        layout: {
          theme: 'default',
          scroll: true,
          height: 300,
          footer: false,

          // enable/disable datatable spinner.
          spinner: {
            type: 1,
            theme: 'default',
          },
        },

        sortable: true,

        // columns definition
        columns: [
          {
            field: 'OrderID',
            title: '#',
            sortable: false,
            width: 20,
            responsive: {hide: 'xl'},
          }, {
            field: 'OrderID',
            title: 'Order ID',
            template: function(row) {
              /*return '<span>' + row.phone + ' - ' + row.phone + '</span>';*/
              return '<span>111111</span>';
            },
          }, {
            field: 'ShipCountry',
            title: 'title',
            width: 100,
          }, {
            field: 'ShipAddress',
            title: 'Payment',
            type: 'number',
          }, {
            field: 'ShipName',
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
              /*return '<span class="m-badge ' + status[row.Status].class + ' m-badge--wide">' + status[row.Status].title + '</span>';*/
              return '<span class="m-badge m-badge--wide">123</span>';
            },
          }, {
            field: 'OrderDate',
            title: 'Type',
            // callback function support for column rendering
            template: function(row) {
              var status = {
                1: {'title': 'Online', 'state': 'danger'},
                2: {'title': 'Retail', 'state': 'primary'},
                3: {'title': 'Direct', 'state': 'accent'},
              };
              /*return '<span class="m-badge m-badge--' + status[row.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.Type].state + '">' + status[row.Type].title + '</span>';*/
              return '<span class="m-badge m-badge--dot"></span>&nbsp;<span class="m--font-bold">9999</span>';
            },
          },],
      });
    }
  };

  return {
    //== Public functions
    init: function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      demo();
    },
  };
}();

jQuery(document).ready(function() {
  DatatableChildRemoteDataDemo.init();
});