
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
let divPassword = null;
let divConfirmPassword = null;
$(document).ready(function () {
    const form = document.getElementById('gestorConfirmForm');
    const button = document.getElementById('submitButton');
    let spinner = $("#loginSpinner");
    //console.log(spinner)
    const fv = FormValidation.formValidation(document.getElementById('gestorConfirmForm'), {
        fields: {
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
        },
        plugins: {
            autoFocus: new FormValidation.plugins.AutoFocus(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: 'is-invalid',
                eleValidClass: '',


            }),
        },
    });
    //get submit button with jquery
    $('#showPassword,#showConfirmPassword').on('click', function () {
        const icon = $(this).find('i');
        const input = $(this).parent().find('input');
        //remove class bi-eye-slash-fill
        if (icon.hasClass('bi-eye-slash-fill')) {
            icon.removeClass('bi-eye-slash-fill');
            icon.addClass('bi-eye-fill');
            input.attr('type', 'text');
        } else {
            icon.removeClass('bi-eye-fill');
            icon.addClass('bi-eye-slash-fill');
            input.attr('type', 'password');
        }
    });

    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()


        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");
        //console.log(spinner)
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
                let data = {};
                $("#gestorConfirmForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });
                $.ajax({
                    type: "POST",
                    url: $("#gestorConfirmForm").attr("action"),
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

                
            }
            setTimeout(() => {
                document.getElementById('submitButton').disabled = false;
                $("#loginSpinner").addClass("d-none");
            }, 3000);
        })



    });

});