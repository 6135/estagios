
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function () {
    //get submit button with jquery
    let offcanvas = document.getElementById('offcanvasNovaPropostaDocente');
    let bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    const fv = FormValidation.formValidation(document.getElementById('docentePropostaForm'), {
        fields: {
            titulo: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.titulo.required
                    },
                    stringLength: {
                        max: 255,
                        min: 16,
                        message: localizedMessages.titulo.between,
                    },
                }
            },
            enquadramento: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.enquadramento.required
                    },
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        min: 256,
                        message: localizedMessages.enquadramento.between,
                    },
                }
            },
            objetivos: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.objetivos.required
                    },
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        min: 256,
                        message: localizedMessages.objetivos.between,
                    },
                }
            },
            plano1: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.plano1.required
                    },
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        min: 256,
                        message: localizedMessages.plano1.between,
                    },
                }
            },
            plano2: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.plano2.required
                    },
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        min: 256,
                        message: localizedMessages.plano2.between,
                    },
                }
            },
            condicoes: {
                validators: {
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        message: localizedMessages.condicoes.max,
                    },
                }
            },
            observacoes: {
                validators: {
                    //max 5000 chars
                    stringLength: {
                        max: 5000,
                        message: localizedMessages.observacoes.max,
                    },
                }
            },
            utilizador_email: {

                validators: {
                    emailAddress: {
                        message: localizedMessages.utilizador_email.email
                    },
                    //must end in @student.dei.uc.pt and be valid via callback. Can be empty  
                    regexp: {
                        message: localizedMessages.utilizador_email.endswith,
                        regexp: /^.+@student.dei.uc.pt$/,
                    },
                    //must be unique via callback
                    callback: {
                        message: localizedMessages.utilizador_email.exist,
                        callback: function (input) {
                            let valid = true;
                            if (input.value.endsWith("@student.dei.uc.pt"))
                                validateEmail(input.value, function (result) {
                                    valid = result;
                                });
                            console.log(valid);
                            return valid;
                        }
                    }
                }

            }
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

    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('docentePropostaForm');
        const button = document.getElementById('submitButton');
        const spinner = $("#loginSpinner");

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
        fv.validate().then(function (status) {
            if (status === 'Invalid') {
                if(!form.checkValidity()){
                    form.reportValidity();
                    button.disabled = false;
                    spinner.addClass("d-none");
                    return;
                }
                button.disabled = false;
                spinner.addClass("d-none");
            } else if (status === 'Valid') {
                //iterate over inputs and select, use name field to build data object
                let data = {};
                $("#docentePropostaForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });
                $.ajax({
                    type: "POST",
                    url: $('#docentePropostaForm').attr("action"),
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