
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function () {
    //get submit button with jquery
    let offcanvas = document.getElementById('offcanvasDadosDocente');
    let bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    let especializacoes = [];
    $.ajax({
        async: false,
        url: '/api/especializacoes/active',
        type: 'GET',
        dataType: "json",
        success: function (result) {
            especializacoes = result
        }

    });
    const fv = FormValidation.formValidation(document.getElementById('docenteDataForm'), {
        fields: {
            nome: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.nome.required
                    },
                    stringLength: {
                        max: 50,
                        min: 3,
                        message: localizedMessages.nome.between,
                    },
                }
            },
            nome_curto: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.nome_curto.required
                    },
                    stringLength: {
                        max: 50,
                        min: 3,
                        message: localizedMessages.nome_curto.between,
                    },
                    regexp: {
                        
                    }
                }
            },
            especializacao_nome: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.especializacao_nome.required
                    },
                    callback: {
                        message: localizedMessages.especializacao_nome.notexists,
                        callback: function (input) {
                            let value = input.value;
                            let isValid = false
                            if (especializacoes.includes(value))
                                isValid = true;
                            return isValid;
                        }
                    }
                }
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
    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('docenteDataForm');
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
                $("#docenteDataForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: $('#docenteDataForm').attr("action"),
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