var adminUsersTable = function() {
    var init = function() {
        //alert('init');
        $('.switch-user-isadmin').on('change', function() {
            //alert('123');
            //console.log('teste.....');
            //bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });

            $.post("/user/setadmin/987", {id: 99}, function(result){
                console.log(result);
            }, "json");
        });
    };

    return {
        init: function() {
            init();
        }
    };
}();

jQuery(document).ready(function() {
    adminUsersTable.init();
});