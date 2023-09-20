
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
let validateCompanyEmail = function(email, callback = null, async = false) {
    data = {email: email};
    let valid = false;
    $.ajax({
        type: "POST",
        async: async,
        url: '/validate/email',
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

