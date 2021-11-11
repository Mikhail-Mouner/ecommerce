require('./bootstrap');
require('bootstrap-fileinput')
require('select2/dist/js/select2.min')

$(function () {
    $("#category-image").fileinput({
        theme: "fas",
        maxFileCount: 1,
        allowedFileTypes: ['image'],
        showCancel: true,
        showRemove: false,
        showUpload: false,
        overwriteInitial: false
    });
    $("#user-image-image").fileinput({
        theme: "fas",
        maxFileCount: 1,
        allowedFileTypes: ['image'],
        showCancel: true,
        showRemove: false,
        showUpload: false,
        overwriteInitial: false
    });
    $("#product-image").fileinput({
        theme: "fas",
        maxFileCount: 5,
        allowedFileTypes: ['image'],
        showCancel: true,
        showRemove: false,
        showUpload: false,
        overwriteInitial: false
    });
    $('.select-2').select2({
        placeholder: 'Select an option'
    });
});