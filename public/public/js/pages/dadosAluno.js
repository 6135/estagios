
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

$(document).ready(function () {
    //get submit button with jquery

    $("#submitButton").on("click", function (e) {
        //prevent default\
        e.preventDefault();
        e.stopImmediatePropagation()

        const form = document.getElementById('studentDataForm');
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
        //iterate over inputs and select, use name field to build data object
        let data = {};
        $("#studentDataForm input, select, textarea").each(function (index, element) {
            data[element.name] = element.value;
        });
        console.log(data);
        $.ajax({
            type: "POST",
            url: $('#studentDataForm').attr("action"),
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

    });

});