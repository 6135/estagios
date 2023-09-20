
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
let divPassword = null;
let divConfirmPassword = null;
$(document).ready(function () {
    const form = document.getElementById('colabConfirmForm');
    const button = document.getElementById('submitButton');
    const spinner = $("#loginSpinner");
    const fv = FormValidation.formValidation(document.getElementById('colabConfirmForm'), {
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
            telefone:{
                validators: {
                    notEmpty: {
                        message: localizedMessages.telefone.required
                    },
                    stringLength: {
                        max: 255,
                        message: localizedMessages.telefone.max,
                    }, // must be at least 8 characters long
                },
            },
            cargo: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.cargo.required
                    },
                    stringLength: {
                        max: 128,
                        message: localizedMessages.cargo.max,
                    },
                },
            },
            password: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.password.required
                    },
                    stringLength: {
                        min: 8,
                        message: localizedMessages.password.min,
                    }, // must be at least 8 characters long
                }
            },
            password_confirmation: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.password_confirmation.required
                    },
                    identical: {
                        message: localizedMessages.password_confirmation.same,
                        compare: function () {
                            return form.querySelector('[name="password"]').value;
                        },
                    },
                    stringLength: {
                        min: 8,
                        message: localizedMessages.password_confirmation.min,
                    }, // must be at least 8 characters long
                }
            },
            formacao: {
                validators: {
                    callback: {
                        message: localizedMessages.formacao.oneselected,
                        callback: function (input) {
                            //check if input.value is in paises
                            form.querySelector('[name="anosexperiencia"]').classList.remove('is-invalid');
                            console.log(form.querySelector('[name="anosexperiencia"]').value);
                            if(input.value === "" && form.querySelector('[name="anosexperiencia"]').value === ""){
                                console.log("here");
                                form.querySelector('[name="anosexperiencia"]').classList.add('is-invalid');
                                return false;
                            } else if(form.querySelector('[name="anosexperiencia"]').value === ""){
                                const found = formacao.find(ele => ele.nome == input.value);
                                return found !== undefined;
                            }
                        }
                    },

                },
            },
            anosexperiencia: {
                validators: {
                    between:{
                        min: 0,
                        max: 50,
                        message: localizedMessages.anosexperiencia.between,
                    },
                },
            },
            cv: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.cv.required
                    },
                    file:{
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 10240 * 1024,
                        message: localizedMessages.cv.mimes
                    },
                },
            },
        },
        plugins: {
            autoFocus: new FormValidation.plugins.AutoFocus(),
            // trigger: new FormValidation.plugins.Trigger(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: 'is-invalid',
                eleValidClass: '',


            }),
        },
    }).on('plugins.message.displayed', function (e) {
        console.log(e.field,e.validator,e);
        if(e.field === 'cv' && e.validator === 'file' && e.meta){
            switch(e.meta.error){
                case 'INVALID_EXTENSION':
                    e.messageElement.innerHTML = localizedMessages.cv.mimes;
                    break;
                case 'INVALID_MAX_SIZE':
                    e.messageElement.innerHTML = localizedMessages.cv.max;
                    break;
                default:
                    break;
            }
        }
        console.log(e.field,e.validator,e);

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
            fv.validateField('password_confirmation').then(function (status) {
                const buttonFirst = document.getElementById('showConfirmPassword');
                if (divConfirmPassword === null)
                    divConfirmPassword = buttonFirst.closest('div').querySelector('.fv-plugins-message-container');
                if (status === "Invalid") {
                    document.getElementById('password_confirmation').classList.add('border-danger');
                    document.getElementById('password_confirmation').classList.remove('is-invalid');

                    //add is-invalid-button class to button
                    buttonFirst.classList.add('border-danger');
                    //get nearest div with class invalid-feedback and move it to grandparent
                    //add class  d-block to div
                    divConfirmPassword.classList.add('d-block');
                    //append div to parent of button 
                    buttonFirst.closest('div').parentElement.appendChild(divConfirmPassword);

                } else if (status === "Valid") {
                    document.getElementById('password_confirmation').classList.remove('border-danger');

                    //remove is-invalid-button class to button
                    buttonFirst.classList.remove('border-danger');

                }
            });
            fv.validateField('password').then(function (status) {
                const buttonFirst = document.getElementById('showPassword');
                if (divPassword === null)
                    divPassword = buttonFirst.closest('div').querySelector('.fv-plugins-message-container');
                if (status === "Invalid") {
                    document.getElementById('password').classList.add('border-danger');
                    document.getElementById('password').classList.remove('is-invalid');
                    //add is-invalid-button class to button
                    buttonFirst.classList.add('border-danger');
                    //get nearest div with class invalid-feedback and move it to grandparent
                    //add class  d-block to div
                    divPassword.classList.add('d-block');
                    //append div to parent of button 
                    buttonFirst.closest('div').parentElement.appendChild(divPassword);

                } else if (status === "Valid") {
                    document.getElementById('password').classList.remove('border-danger');
                    //remove is-invalid-button class to button
                    buttonFirst.classList.remove('border-danger');

                }
            });
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
                // let data = {};
                // $("#colabConfirmForm input, select, textarea").each(function (index, element) {
                //     data[element.name] = element.value;
                // });
                let data = new FormData(form);
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: $("#colabConfirmForm").attr("action"),
                    data: data,
                    processData: false,
                    contentType: false,
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

                
            }
            setTimeout(() => {
                document.getElementById('submitButton').disabled = false;
                $("#loginSpinner").addClass("d-none");
            }, 3000);
        })



    });

});