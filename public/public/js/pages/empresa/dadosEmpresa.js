
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function () {
    //get submit button with jquery
    let offcanvas = document.getElementById('offcanvasDadosEmpresa');
    let bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    const fv = FormValidation.formValidation(document.getElementById('empresaDataForm'), {
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

    // console.log(FormValidation.plugins);
    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('empresaDataForm');
        const button = document.getElementById('submitButton');
        const spinner = $("#loginSpinner");

        let updateData = function (data) {
            //for each element in data
            for (const [key, value] of Object.entries(data)) {
                //find each p element with the same name as the key
                if(key == 'nomeempresa')
                    $(`p[name=field_nomeempresa]`).text(value + " / " + data['acronimo']);
                else if(key == 'url')//set src and value to value of key;
                    $(`p[name=field_${key}]`).html(`<a href="${value}" class="text-black" target="_blank">${value}</a>`);
                else if(key != 'acronimo')
                    $(`p[name=field_${key}]`).text(value);
            }
        };
        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");
        console.log("clicked");
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
                let data = {};
                $("#empresaDataForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });
                $.ajax({
                    type: "POST",
                    url: $('#empresaDataForm').attr("action"),
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