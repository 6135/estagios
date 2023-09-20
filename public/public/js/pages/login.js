
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

$(document).ready(function () {
    //get submit button with jquery
    $('#showPassword').on('click', function () {
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

        const form = document.getElementById('loginForm');
        const button = document.getElementById('submitButton');
        const spinner = $("#loginSpinner");
        button.disabled = true;
        //unhide loginSpinner 
        spinner.removeClass("d-none");

        if (!form.checkValidity()) {
            form.reportValidity();
            button.disabled = false;
            spinner.addClass("d-none");
            return;
        }

        console.log("clicked");

        $.ajax({
            type: "POST",
            url: $("#loginForm").attr("action"),
            data: {
                email: $("#email").val(),
                password: $("#password").val(),
                // _token: ""
            },
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

    });

});