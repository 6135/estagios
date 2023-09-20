
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
let divPassword = null;
let divConfirmPassword = null;
$(document).ready(function () {
    const form = document.getElementById('registerForm');
    const button = document.getElementById('submitButton');
    const spinner = $("#loginSpinner");
    const fv = FormValidation.formValidation(document.getElementById('registerForm'), {
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: localizedMessages.email.required
                    },
                    emailAddress: {
                        message: localizedMessages.email.email,
                    },
                    callback: {
                        message: localizedMessages.email.notunique,
                        callback: function (input) {
                            let valid = true;
                            console.log(input.value);
                            validateCompanyEmail(input.value, function (result) {
                                console.log(result);
                                valid = result;
                            });
                            console.log(valid);
                            return valid;
                        }
                    },


                }
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
                rowSelector: '.form-floating',
                eleInvalidClass: 'is-invalid-dei',
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
        fv.validate().then(function (status) {
            fv.validateField('password_confirmation').then(function (status) {
                const buttonFirst = document.getElementById('showConfirmPassword');
                if (divConfirmPassword === null)
                    divConfirmPassword = buttonFirst.closest('div').querySelector('.fv-plugins-message-container');
                if (status === "Invalid") {
                    //add is-invalid-button class to button
                    buttonFirst.classList.add('is-invalid-button');
                    //get nearest div with class invalid-feedback and move it to grandparent
                    //add class  d-block to div
                    divConfirmPassword.classList.add('d-block');
                    //append div to parent of button 
                    buttonFirst.closest('div').parentElement.appendChild(divConfirmPassword);

                } else if (status === "Valid") {
                    //remove is-invalid-button class to button
                    buttonFirst.classList.remove('is-invalid-button');

                }
            });
            fv.validateField('password').then(function (status) {
                const buttonFirst = document.getElementById('showPassword');
                if (divPassword === null)
                    divPassword = buttonFirst.closest('div').querySelector('.fv-plugins-message-container');
                if (status === "Invalid") {
                    //add is-invalid-button class to button
                    buttonFirst.classList.add('is-invalid-button');
                    //get nearest div with class invalid-feedback and move it to grandparent
                    //add class  d-block to div
                    divPassword.classList.add('d-block');
                    //append div to parent of button 
                    buttonFirst.closest('div').parentElement.appendChild(divPassword);

                } else if (status === "Valid") {
                    //remove is-invalid-button class to button
                    buttonFirst.classList.remove('is-invalid-button');

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
                $("#registerForm input, select, textarea").each(function (index, element) {
                    data[element.name] = element.value;
                });

                $.ajax({
                    type: "POST",
                    url: $("#registerForm").attr("action"),
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            toastr.success(result.message);
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