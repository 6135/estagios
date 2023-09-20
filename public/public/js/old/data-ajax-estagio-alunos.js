"use strict";

// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterProfile;

    // Private functions
    var initDatatable = function () {
        //TODO: Fix student filters
        dt = $("#kt_datatable_estagio_candidatos").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[5, 'desc']],
            stateSave: false    ,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: `${tableActionURL}`,
            },
            columns: [
                // { data: 'idaluno'},
                { data: 'nomealuno' },
                { data: 'emailaluno' },
                { data: 'perfiladequado'},
                { data: 'num_escolha' },
                { data: 'medialicenciatura'},
                { data: 'cvaluno'},
                { data: 'operationOID' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: true,
                    render: function (data,type,row) {
                        return data;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function (data,type,row) {
                        return data+"@student.dei.uc.pt";
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function (data,type,row) {
                        // console.log(row);
                        // console.log(tableActionURL);
                        if(data == 1)
                            return `<span style=\"color: #ffffff;\" class=\"badge badge-success\" >Sim</span>`;
                        else if(data == "null")
                            return `<span style=\"color: #ffffff;\" class=\"badge badge-warning\" >Por aprovar</span>`;
                        else
                            return `<span style=\"color: #ffffff;\" class=\"badge badge-danger\" >Não</span>`;

                        // return `<span style=\"color: #ffffff;\" class=\"badge badge-${row.estadoestagiobadge}\" >${row.estadoestagiotext}</span>`;
                    }
                }, {
                    targets: 5,
                    orderable: false,
                    render: function (data,type,row) {

                      return `<a href="https://intra.estagios.dei.uc.pt/app/alunos/showCV.php?file=${data}"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
</svg></a>`
                    }
                     
                },
                {

                    targets: -1,
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <button data-kt-docs-table-url="${compareAction}/${data}/1" class="btn btn-outline btn-outline-success px-3 mb-3" style="min-width:  5px" data-kt-docs-table-filter="accept_row"> Aceitar </button>
                            <button data-kt-docs-table-url="${compareAction}/${data}/2" class="btn btn-outline btn-outline-danger  px-3 mb-3" style="min-width:  5px" data-kt-docs-table-filter="reject_row" > Rejeitar </button>
                        `;
                    },
                },
            ],
            // // Add data-filter attribute
            // createdRow: function (row, data, dataIndex) {
            //     $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            // }
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            // initToggleToolbar();
            // toggleToolbars();
            handleManageRows();
            KTMenu.createInstances();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        filterProfile = document.querySelectorAll('[data-kt-docs-table-filter="perfiladequado"] [name="perfiladequado"]');
        const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            // Get filter values
            let profileValue = '';

            // Get payment value
            filterProfile.forEach(r => {
                console.log(r);
                if (r.checked) {
                    profileValue = r.value;
                }

                // Reset payment value if "All" is selected
                if (profileValue === 'all') {
                    profileValue = '';
                }
            });

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            dt.columns(2).search(profileValue).draw();
        });
    }


    var handleManageRows = () => {
        // Select all accept buttons
        const acceptButtons = document.querySelectorAll('[data-kt-docs-table-filter="accept_row"]');
        const rejectButtons = document.querySelectorAll('[data-kt-docs-table-filter="reject_row"]');
        acceptButtons.forEach(d => {

            d.addEventListener('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: d.getAttribute('data-kt-docs-table-url'),
                    type: 'GET',
                    success: function (data) {
                        dt.ajax.reload();
                    },
                });

            });
        });
        rejectButtons.forEach(d => {

            d.addEventListener('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: d.getAttribute('data-kt-docs-table-url'),
                    type: 'GET',
                    success: function (data) {
                        dt.ajax.reload();
                    },
                });

            });
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Reset payment type
            filterPayment[0].checked = true;

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            dt.search('').draw();
        });
    }

    // Init toggle toolbar
    // var initToggleToolbar = function () {
    //     // Toggle selected action toolbar
    //     // Select all checkboxes
    //     const container = document.querySelector('#kt_datatable_estagios');
    //     const checkboxes = container.querySelectorAll('[type="checkbox"]');
    //
    //     // Select elements
    //     const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');
    //
    //     // Toggle delete selected toolbar
    //     checkboxes.forEach(c => {
    //         // Checkbox on click event
    //         c.addEventListener('click', function () {
    //             setTimeout(function () {
    //                 toggleToolbars();
    //             }, 50);
    //         });
    //     });
    //
    //     // Deleted selected rows
    //     deleteSelected.addEventListener('click', function () {
    //         // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
    //         Swal.fire({
    //             text: "Are you sure you want to delete selected customers?",
    //             icon: "warning",
    //             showCancelButton: true,
    //             buttonsStyling: false,
    //             showLoaderOnConfirm: true,
    //             confirmButtonText: "Yes, delete!",
    //             cancelButtonText: "No, cancel",
    //             customClass: {
    //                 confirmButton: "btn fw-bold btn-danger",
    //                 cancelButton: "btn fw-bold btn-active-light-primary"
    //             },
    //         }).then(function (result) {
    //             if (result.value) {
    //                 // Simulate delete request -- for demo purpose only
    //                 Swal.fire({
    //                     text: "Deleting selected customers",
    //                     icon: "info",
    //                     buttonsStyling: false,
    //                     showConfirmButton: false,
    //                     timer: 2000
    //                 }).then(function () {
    //                     Swal.fire({
    //                         text: "You have deleted all selected customers!.",
    //                         icon: "success",
    //                         buttonsStyling: false,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn fw-bold btn-primary",
    //                         }
    //                     }).then(function () {
    //                         // delete row data from server and re-draw datatable
    //                         dt.draw();
    //                     });
    //
    //                     // Remove header checked box
    //                     const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
    //                     headerCheckbox.checked = false;
    //                 });
    //             } else if (result.dismiss === 'cancel') {
    //                 Swal.fire({
    //                     text: "Selected customers was not deleted.",
    //                     icon: "error",
    //                     buttonsStyling: false,
    //                     confirmButtonText: "Ok, got it!",
    //                     customClass: {
    //                         confirmButton: "btn fw-bold btn-primary",
    //                     }
    //                 });
    //             }
    //         });
    //     });
    // }

    // Toggle toolbars
    // var toggleToolbars = function () {
    //     // Define variables
    //     const container = document.querySelector('#kt_datatable_estagio');
    //     const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
    //     const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
    //     const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');
    //
    //     // Select refreshed checkbox DOM elements
    //     const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
    //
    //     // Detect checkboxes state & count
    //     let checkedState = false;
    //     let count = 0;
    //
    //     // Count checked boxes
    //     allCheckboxes.forEach(c => {
    //         if (c.checked) {
    //             checkedState = true;
    //             count++;
    //         }
    //     });
    //
    //     // Toggle toolbars
    //     if (checkedState) {
    //         selectedCount.innerHTML = count;
    //         toolbarBase.classList.add('d-none');
    //         toolbarSelected.classList.remove('d-none');
    //     } else {
    //         toolbarBase.classList.remove('d-none');
    //         toolbarSelected.classList.add('d-none');
    //     }
    // }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            // initToggleToolbar();
            handleFilterDatatable();
            handleManageRows();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});