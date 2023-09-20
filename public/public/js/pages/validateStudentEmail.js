
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
let validateEmail = function(email, callback = null, async = false) {
    data = {student_email: email};
    let valid = false;
    $.ajax({
        type: "POST",
        async: async,
        url: '/aluno/validate/email',
        data: data,
        dataType: "json",
        success: function (result) {
            valid = result.success;
            callback(valid);
        },
        fail: function (xhr, textStatus, errorThrown) {
            toastr.error(textStatus);
        },
    });
    return valid;
};

