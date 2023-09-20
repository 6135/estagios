"use strict";

// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {

        dt = $("#kt_datatable_estagios").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[4, 'desc']],
            stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: `${tableActionURL}`,
            },
            columns: [
                { data: 'idestagio' },
                { data: 'tituloestagio' },
                { data: 'responsaveis' },
                { data: 'nomealuno' },
                { data: 'estadoestagio' },
                { data: 'candidatosCount' },
                { data: 'operationOID' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: true,
                    render: function (data, type, row) {
                        return `<a href="${tableEditAction}/${row.operationOID}">${data}</a>`;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function (data, type, row) {
                        return `<a href="${tableEditAction}/${row.operationOID}">${data}</a>`;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function (data, type, row) {
                        return `<span style=\"color: #ffffff;\" class=\"badge badge-${row.estadoestagiobadge}\" >${row.estadoestagiotext}</span>`;
                    }
                },

                {

                    targets: -1,
                    orderable: false,
                    render: function (data, type, row) {
                        return `

                                <a href="${tableCandidatosAction}/${data}" class="menu-link px-3" style="margin-right: 7px" data-kt-docs-table-filter="edit_row">
                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/communication/com014.svg-->
                                        <span title="Candidatos" class="svg-icon svg-icon-primary svg-icon-2hx position-absolute"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                            <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                            </svg>
                                        </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="${tableEditAction}/${data}" class="menu-link px-4" style="margin-left: 7px" data-kt-docs-table-filter="edit_row">
                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/general/gen004.svg-->
                                    <span title="${actionName}" class="svg-icon svg-icon-primary svg-icon-2hx position-absolute"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor"/>
                                    <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon-->        
                                </a>
                            `;

                        //     <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                        //         Ações
                        //         <span class="svg-icon svg-icon-5 m-0">
                        //             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        //                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        //                     <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        //                     <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                        //                 </g>
                        //             </svg>
                        //         </span>
                        //     </a>
                        //     <!--begin::Menu-->
                        //     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                        //         <!--begin::Menu item-->
                        //         <div class="menu-item px-3" ${profile != 1 ? `hidden` : ``}>
                        //             <a href="#" class="menu-link px-3" data-kt-docs-table-filter="see_row">
                        //                 Detalhes
                        //             </a>
                        //         </div>
                        //         <!--end::Menu item-->

                        //         <!--begin::Menu item-->
                        //         <div class="menu-item px-3">
                        //             <a href="${tableEditAction}/${data}" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                        //                  ${actionName}
                        //             </a>
                        //         </div>
                        //         <!--end::Menu item-->
                        //         <!--begin::Menu item-->
                        //         <div class="menu-item px-3">
                        //             <a href="${tableCandidatosAction}/${data}" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                        //                 Candidatos
                        //             </a>
                        //         </div>
                        //         <!--end::Menu item-->
                        //     </div>
                        //     <!--end::Menu-->
                        // `;
                        //     <div class="menu-item px-3" ${profile != 1 ? `hidden` : ``}>
                        //     <a href="${compareAction}/${data}" class="menu-link px-3" data-kt-docs-table-filter="_row" >
                        //         Comparar
                        //     </a>
                        // </div>
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
            // handleDeleteRows();
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
        filterPayment = document.querySelectorAll('[data-kt-docs-table-filter="state_type"] [name="state_type"]');
        const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            // Get filter values
            let paymentValue = '';

            // Get payment value
            filterPayment.forEach(r => {
                console.log(r);
                if (r.checked) {
                    paymentValue = r.value;
                }

                // Reset payment value if "All" is selected
                if (paymentValue === 'all') {
                    paymentValue = '';
                }
            });

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            dt.search(paymentValue).draw();
        });
    }

    // Delete customer
    // var handleDeleteRows = () => {
    //     // Select all delete buttons
    //     const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');
    //
    //     deleteButtons.forEach(d => {
    //         // Delete button on click
    //         d.addEventListener('click', function (e) {
    //             e.preventDefault();
    //
    //             // Select parent row
    //             const parent = e.target.closest('tr');
    //
    //             // Get customer name
    //             const customerName = parent.querySelectorAll('td')[1].innerText;
    //
    //             // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
    //             Swal.fire({
    //                 text: "Are you sure you want to delete " + customerName + "?",
    //                 icon: "warning",
    //                 showCancelButton: true,
    //                 buttonsStyling: false,
    //                 confirmButtonText: "Yes, delete!",
    //                 cancelButtonText: "No, cancel",
    //                 customClass: {
    //                     confirmButton: "btn fw-bold btn-danger",
    //                     cancelButton: "btn fw-bold btn-active-light-primary"
    //                 }
    //             }).then(function (result) {
    //                 if (result.value) {
    //                     // Simulate delete request -- for demo purpose only
    //                     Swal.fire({
    //                         text: "Deleting " + customerName,
    //                         icon: "info",
    //                         buttonsStyling: false,
    //                         showConfirmButton: false,
    //                         timer: 2000
    //                     }).then(function () {
    //                         Swal.fire({
    //                             text: "You have deleted " + customerName + "!.",
    //                             icon: "success",
    //                             buttonsStyling: false,
    //                             confirmButtonText: "Ok, got it!",
    //                             customClass: {
    //                                 confirmButton: "btn fw-bold btn-primary",
    //                             }
    //                         }).then(function () {
    //                             // delete row data from server and re-draw datatable
    //                             dt.draw();
    //                         });
    //                     });
    //                 } else if (result.dismiss === 'cancel') {
    //                     Swal.fire({
    //                         text: customerName + " was not deleted.",
    //                         icon: "error",
    //                         buttonsStyling: false,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn fw-bold btn-primary",
    //                         }
    //                     });
    //                 }
    //             });
    //         })
    //     });
    // }

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
            // handleDeleteRows();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});