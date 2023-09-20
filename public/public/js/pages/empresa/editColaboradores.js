
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function () {
    //get submit button with jquery
    // let offcanvas = document.getElementById('offcanvasRequestColaborador');
    // let bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    let bsOffcanvas = editColaboratorOffcanvas
    const fv = FormValidation.formValidation(document.getElementById('editColaboradorForm'), {
        fields :{
            nome: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.nome.required
                    },
                    stringLength: {
                        min: 3,
                        max: 512,
                        message: localizedMessages.nome.between,
                    }, // must be at least 8 characters long

                },
            },
            email: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.email.required
                    },
                    stringLength: {
                        max: 512,
                        message: localizedMessages.email.max,
                    },
                    emailAddress: {
                        message: localizedMessages.email.email,
                    }
                },
            },
        },

        plugins: {
            autoFocus: new FormValidation.plugins.AutoFocus(),
            trigger: new FormValidation.plugins.Trigger(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: 'is-invalid',
                eleValidClass: '',


            }),
        },
    });

    // console.log(FormValidation.plugins);
    $("#submitButtonEditColab").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('editColaboradorForm');
        const button = document.getElementById('submitButtonEditColab');
        const spinner = $("#spinnerEditColab");

        let updateData = function (data){
            DatatablesStuff.ajaxReload();
        };
        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");
        //iterate over inputs and select, use name field to build data object
        fv.validate().then(function (status) {
            if (status == 'Invalid') {
                if (!form.checkValidity()) {
                    form.reportValidity();
                    button.disabled = false;
                    spinner.addClass("d-none");
                    return;
                }
                button.disabled = false;
                spinner.addClass("d-none");
            } else if (status === 'Valid') {
                let data = {};//several input named cargos should be an array
                $("#editColaboradorForm input, select, textarea").each(function (index, element) {
                    //check if element name is cargos
                    if (element.name == "cargos") {
                        //check if cargos is already an array
                        if (Array.isArray(data[element.name])) {
                            //push value to array
                            data[element.name].push(element.value);
                        } else {
                            //create array with value
                            data[element.name] = [element.value];
                        }
                    } else data[element.name] = element.value;
                });
                $.ajax({
                    type: "POST",
                    url: $('#editColaboradorForm').attr("action"),
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            toastr.success(result.message);
                            setTimeout(() => {
                                updateData(data);
                                button.disabled = false;
                                spinner.addClass("d-none");
                                bsOffcanvas.toggle();
                            }, 1000);
                        } else {

                            toastr.error(result.message);
                            button.disabled = false;
                            spinner.addClass("d-none");

                        }
                    },
                    fail: function (xhr, textStatus, errorThrown) {
                        toastr.error(textStatus);
                        button.disabled = false;
                        spinner.addClass("d-none");

                    },
                    dataType: "json"
                });
            }
        });





    });

});