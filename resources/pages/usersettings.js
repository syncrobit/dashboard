$(document).ready(function(){
    $('.select2noimg').select2({
        placeholder: function () {
            $(this).data('placeholder').trigger('change');
        },
    }).on("select2:close", function (e) {
        $(this).valid();
    });
})