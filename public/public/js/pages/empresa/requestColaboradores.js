
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function () {
    //get submit button with jquery
    let offcanvas = document.getElementById('offcanvasRequestColaborador');
    let bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    const fv = FormValidation.formValidation(document.getElementById('requestGestorForm'), {
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
    $("#submitButtonGestor").on("click", function (e) {
        console.log("clicked");
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('requestGestorForm');
        const button = document.getElementById('submitButtonGestor');
        const spinner = $("#spinnerGestor");

        let updateData = function (data) {
            //for each element in data
            for (const [key, value] of Object.entries(data)) {
                //find each p element with the same name as the key
                $(`p[name=field_${key}]`).text(value);
            }
        };
        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");
        console.log("clicked");
        //iterate over inputs and select, use name field to build data object
        fv.validate().then(function (status) {
            console.log(status);
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
                let data = {};
                $("#requestGestorForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: $('#requestGestorForm').attr("action"),
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