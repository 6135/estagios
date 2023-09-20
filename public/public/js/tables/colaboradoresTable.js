

// Class definition
var DatatablesStuff = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    var tableID = "ColaboradoresTable";
    // Private functions
    var initDatatable = function () {
        dt = $("#"+tableID).DataTable({
            dom: 
            "<'row'<'col-lg-12 table-responsive'tr>>" +
            "<'row'<'col-md-5'<'row'<'col-md'l>>><'col-md-7'p>>",
            language: {
                "lengthMenu": "_MENU_ ",
                "zeroRecords": localizedMessages.zeroRecords,
                "infoEmpty": localizedMessages.infoEmpty,//"No records available",
                // "infoFiltered": "(filtered from _MAX_ total records)"
            },
            // responsive: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100,],
            searchDelay: 500,
            processing: false,
            serverSide: false,
            order: [[1, 'asc']],
            stateSave: true,
            autoWidth: false,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: dataURL,
            },
            columns: [
                { data: 'nome_curto' }, //0
                { data: 'email' }, //1
                { data: 'cargo'}, //2
                { data: 'telefone'}, //3
                { data: 'estado' }, //4
                { data: 'papels'}, //5
                { data: null} //6
                // <th class="text-primary" id="Header.roles"                              >{{trans_choice("words.role",2)}}</th>
                // <th class="text-primary" id="Header.action" style="min-width: 50px"     ></th>
            ],
            columnDefs: [
                //Email with link
                {
                    targets: 1,
                    orderable: true,
                    render: function (data, type, row) {
                        return `<a class="text-black" style="text-transform: uppercase; font-size: 1.05rem" href="mailto:${data}">${data}</a>`;
                    }
                },

                {
                    targets: 4,
                    orderable: true,
                    render: function (data, type, row) {
                        let badge = "badge rounded-pill text-bg-primary text-white";
                        if(row['ativo'] && row['confirmacao'])
                            badge = "badge rounded-pill text-bg-primary text-white";
                        else if (row['ativo'] && !row['confirmacao'])
                            badge = "badge rounded-pill text-bg-secondary";
                        else if (!row['ativo'])
                            badge = "badge rounded-pill text-bg-dark";
                        return `<span class="${badge} py-2 px-3" style="text-transform: uppercase; font-size: 0.7rem !important">${data}</span>`;
                    }
                },
                //add action buttons, one for deactivation or activation and one for edit
                {
                    targets: 6,
                    orderable: false,
                    render: function (data, type, row) {
                        //inline buttons that activate/deactivate a user or edit it
                        let changeState = "Activate";
                        let state = false;
                        if(row['ativo']){
                            changeState = localizedMessages.changeState.deactivate;
                            state = false;
                        }
                        else{
                            changeState = localizedMessages.changeState.activate;
                            state = true;
                        }
                        let rowData = JSON.stringify(row);
                        rowData = rowData.replace(/"/g, '\'');
                        let buttons = `<div class="d-flex justify-content-end flex-shrink-0">
                                            <a type="button" data-link="${changeStateURL}" data-email="${row['email']}" data-state="${state}" class="text-primary state-account-trigger" style="font-size: 1.1rem">
                                            ${changeState}</a>&nbsp;/&nbsp;
                                            <a type="button" data-link="${editURL}" data-email="${row['email']}" data-row="${rowData}" data-nome="${row['nome']}" class="text-primary edit-account-trigger" style="font-size: 1.1rem">
                                            ${localizedMessages.edit}</a>
                                        </div>`;
                        return buttons;
                    }
                    
                },
                
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            handleActions();
            // initToggleToolbar();
            // toggleToolbars();
            // handleDeleteRows();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('#tableSearch');
        console.log(filterSearch)
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        $("#dropdown-toggle-state").next(".dropdown-menu").children().on("click", function() {
            $(this).closest(".dropdown-menu").prev(".dropdown-toggle").children('.displayed-text').html($(this).text());
            //get classes custom attribute from clicked element
            var classes = $(this).children(":first").attr("classes");
            //set classes custom attribute to the dropdown toggle button
            $(this).closest(".dropdown-menu").prev(".dropdown-toggle").attr("class", classes);
            const selectA = $(this).children(":first");
            const value = selectA.attr("value");
            console.log(value); 
            if(value === "0"){
                dt.column(4).search("").draw();
            }else{
                dt.column(4).search("^" + $(this).text() + "$", true, false, true).draw();  
            }
        });

        //     // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
        //     dt.search(paymentValue).draw();
        // });
    }

    // Delete customer
    // var handleDeleteRows = () => {
    //     // Select all delete buttons
    //     const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

    //     deleteButtons.forEach(d => {
    //         // Delete button on click
    //         d.addEventListener('click', function (e) {
    //             e.preventDefault();

    //             // Select parent row
    //             const parent = e.target.closest('tr');

    //             // Get customer name
    //             const customerName = parent.querySelectorAll('td')[1].innerText;

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
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#'+tableID);
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        // const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        // deleteSelected.addEventListener('click', function () {
        //     // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
        //     Swal.fire({
        //         text: "Are you sure you want to delete selected customers?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         buttonsStyling: false,
        //         showLoaderOnConfirm: true,
        //         confirmButtonText: "Yes, delete!",
        //         cancelButtonText: "No, cancel",
        //         customClass: {
        //             confirmButton: "btn fw-bold btn-danger",
        //             cancelButton: "btn fw-bold btn-active-light-primary"
        //         },
        //     }).then(function (result) {
        //         if (result.value) {
        //             // Simulate delete request -- for demo purpose only
        //             Swal.fire({
        //                 text: "Deleting selected customers",
        //                 icon: "info",
        //                 buttonsStyling: false,
        //                 showConfirmButton: false,
        //                 timer: 2000
        //             }).then(function () {
        //                 Swal.fire({
        //                     text: "You have deleted all selected customers!.",
        //                     icon: "success",
        //                     buttonsStyling: false,
        //                     confirmButtonText: "Ok, got it!",
        //                     customClass: {
        //                         confirmButton: "btn fw-bold btn-primary",
        //                     }
        //                 }).then(function () {
        //                     // delete row data from server and re-draw datatable
        //                     dt.draw();
        //                 });

        //                 // Remove header checked box
        //                 const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
        //                 headerCheckbox.checked = false;
        //             });
        //         } else if (result.dismiss === 'cancel') {
        //             Swal.fire({
        //                 text: "Selected customers was not deleted.",
        //                 icon: "error",
        //                 buttonsStyling: false,
        //                 confirmButtonText: "Ok, got it!",
        //                 customClass: {
        //                     confirmButton: "btn fw-bold btn-primary",
        //                 }
        //             });
        //         }
        //     });
        // });
    }

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#'+tableID);
        const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    var handleActions = function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $('.cargo-clear').on('click', function (e) {
            $(this).parent().parent().addClass('d-none');
            $(this).parent().parent().find('select').val('').change();
        })
        //on select, find next cargo-select and unhide it
        $('.cargo-select').on('change', function (e) {
            //if self is hidden, unhide it
            if($(this).parent().parent().hasClass('d-none') && $(this).val() != '-1')
                $(this).parent().parent().removeClass('d-none');

            if($(this).val() == '-1')
                $(this).parent().parent().next().addClass('d-none');
            else $(this).parent().parent().next().removeClass('d-none');
            // console.log($(this).attr('id'),$(this).parent().parent().next().find('select'));
        })

        $('.state-account-trigger').on('click', function (e) {
            //get link custom attr
            let link = $(this).attr('data-link');
            let email = $(this).attr('data-email');
            let state = $(this).attr('data-state');

            console.log(link, email, state);
            //if it fails, it will show error message
            $.ajax({
                url: link,
                type: 'POST',
                data: {
                    email: email,
                    state: state
                },
                success: function (data) {
                    console.log(data);
                    if (data.success === true) {
                        toastr.success(data.message);
                        dt.ajax.reload();
                        dt.draw();
                    } else {
                        toastr.error(data.message);

                    }
                }


            });
        });

        $('.edit-account-trigger').on('click', function (e) {
            //get link custom attr
            let link = $(this).attr('data-link'); 
            let email = $(this).attr('data-email');
            let rowData = $(this).attr('data-row');
            $('#nomeEdit').val($(this).attr('data-nome'));
            $('#emailEdit').val(email);
            
            rowData = rowData.replace(/'/g, '\"');
            rowData = JSON.parse(rowData);
            editColaboratorOffcanvas.show();

            let cargo2 = $('#cargo2');
            cargo2.val('-1').change();
            let cargo1 = $('#cargo1');
            cargo1.val('-1').change();
            let cargo0 = $('#cargo0');
            cargo0.val('-1').change();


            let papeis = rowData.papeis;
            for (let i = 0; i < papeis.length; i++) {
                let papel = papeis[i];
                $('#cargo'+i).val(papel.tipo).change();
                // $('#cargo'+i).parent().parent().removeClass('d-none');
            }

        });
        //clear selected option on select in previous div

    }
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            // initToggleToolbar();
            handleFilterDatatable();
            // handleDeleteRows();
            // handleResetForm();
            handleActions();
            setInterval(function () {
                dt.ajax.reload();
            }, 120000);

        },

        ajaxReload: function () {
            dt.ajax.reload();
        }
    }
}();

// On document ready
$(function () {
    DatatablesStuff.init();
});

