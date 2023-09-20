
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
let divPassword = null;
let divConfirmPassword = null;
$(document).ready(function () {
    const form = document.getElementById('companyConfirmForm');
    const button = document.getElementById('submitButton');
    const spinner = $("#loginSpinner");
    const fv = FormValidation.formValidation(document.getElementById('companyConfirmForm'), {
        fields :{
            nomeempresa: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.nomeempresa.required
                    },
                    stringLength: {
                        min: 3,
                        max: 512,
                        message: localizedMessages.empresa.nomeempresa.between,
                    }, // must be at least 8 characters long

                },
            },
            acronimo: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.acronimo.required
                    },
                    stringLength: {
                        min: 1,
                        max: 16,
                        message: localizedMessages.empresa.acronimo.between,
                    }, // must be at least 8 characters long
                },
            },
            morada: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.morada.required
                    },
                    stringLength: {
                        min: 8,
                        max: 512,
                        message: localizedMessages.empresa.morada.between,
                    }, // must be at least 8 characters long
                },
            },
            pais_codigo_iso: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.pais_codigo_iso.required
                    },
                    callback: {
                        message: localizedMessages.empresa.pais_codigo_iso.notexists,
                        callback: function (input) {
                            //check if input.value is in paises
                            const found = paises.find(ele => ele.codigo_iso == input.value);
                            return found !== undefined;
                        }
                    }
                },
            },
            telefone: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.telefone.required
                    },
                },
            }, 
            nif: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.nif.required
                    },
                },
            },
            atividade: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.empresa.atividade.required
                    },
                    stringLength: {
                        min: 8,
                        max: 1024,
                        message: localizedMessages.empresa.atividade.between,
                    },
                },
            },
            url:{
                validators: {
                    uri: {
                        message: localizedMessages.empresa.url.url,
                        protocol: "http, https",
                        allowLocal: false,
                        allowEmptyProtocol: true,
                    }
                }
            },
            nome: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.gestor.nome.required
                    },
                    stringLength: {
                        max: 255,
                        message: localizedMessages.gestor.nome.max,
                    },
                },
            },
            cargo: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.gestor.cargo.required
                    },
                    stringLength: {
                        max: 128,
                        message: localizedMessages.gestor.cargo.max,
                    },
                },
            },
            nome_representante_legal: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.legalrep.nome_representante_legal.required
                    },
                    stringLength: {
                        max: 255,
                        message: localizedMessages.legalrep.nome_representante_legal.max,
                    },
                },
            },
            cargo_representante_legal: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.legalrep.cargo_representante_legal.required
                    },
                    stringLength: {
                        max: 128,
                        message: localizedMessages.legalrep.cargo_representante_legal.max,
                    },
                },
            },
            email: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.legalrep.email.required
                    },
                    emailAddress: {
                        message: localizedMessages.legalrep.email.email,
                    },
                    stringLength: {
                        max: 255,
                        message: localizedMessages.legalrep.email.max,
                    },
                },
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.legalrep.phone.required
                    },
                    stringLength: {
                        max: 32,
                        message: localizedMessages.legalrep.phone.max,
                    },
                },
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
    //get submit button with jquery

    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()


        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");
        fv.validate().then(function (status) {
            if (status === "Invalid") {
                //check if password is invalid

                if (!form.checkValidity()) {
                    form.reportValidity();
                    document.getElementById('submitButton').disabled = false;
                    $("#loginSpinner").addClass("d-none");
                    return;
                }
                document.getElementById('submitButton').disabled = false;
                $("#loginSpinner").addClass("d-none");
            } else if (status === "Valid") {
                let data = {};
                $("#companyConfirmForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });

                $.ajax({
                    type: "POST",
                    url: $("#companyConfirmForm").attr("action"),
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            toastr.success(result.message);
                            setTimeout(() => {
                                window.location.href = result.redirect;
                            }, 1500);
                        } else {

                            toastr.error(result.message);
                            document.getElementById('submitButton').disabled = false;
                            $("#loginSpinner").addClass("d-none");

                        }
                    },
                    fail: function (xhr, textStatus, errorThrown) {
                        toastr.error(textStatus);
                        document.getElementById('submitButton').disabled = false;
                        $("#loginSpinner").addClass("d-none");

                    },
                    dataType: "json"
                });

                document.getElementById('submitButton').disabled = false;
                $("#loginSpinner").addClass("d-none");
            }
        })



    });

});