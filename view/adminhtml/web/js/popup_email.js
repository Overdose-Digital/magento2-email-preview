define([
    'jquery'
], function ($) {
    'use strict';

    return function (config) {
        $('#popup-submit').on('click', function () {
            let optionsName = ['preview_template_id', 'order_id', 'customer_id', 'creditmemo_id', 'store_id'];
            let formData = [];
            for (let name of optionsName) {
                formData[name] = $(`select.${name} option:not([disabled]):selected`).val();
            }
            let id = $('#preview_template_id').val();
            let windowUrl = config.url + `?preview_template_id=${id}&order_id=${formData['order_id']}&customer_id=${formData['customer_id']}&store_id=${formData['store_id']}&creditmemo_id=${formData['creditmemo_id']}`;

            window.open(windowUrl, 'Email Template', "height=800,width=800");
        })
    }
});
