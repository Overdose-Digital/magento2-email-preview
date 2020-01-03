define([
    'jquery',
], function (
    $,
) {
    'use strict';

    return function (config) {

        $('#popup-submit').on('click', function () {
            console.log('click');
            let optionsName = ['order_id', 'customer_id', 'store_id'];
            let formData = [];
            for (let name of optionsName) {
                formData[name] = $(`select.${name} option:not([disabled]):selected`).val();
            }
            let templateId = $('#template_id').val();
            let windowUrl = config.url + `?template_id=${templateId}&order_id=${formData['order_id']}&customer_id=${formData['customer_id']}&store_id=${formData['store_id']}`;

            window.open(windowUrl, 'Email Template', "height=800,width=800");
        })
    }

});