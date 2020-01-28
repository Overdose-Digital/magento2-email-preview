define([
    'jquery',
], function (
    $,
) {
    'use strict';

    return function (config) {

        $('#popup-submit').on('click', function () {
            let optionsName = ['id', 'order_id', 'customer_id', 'store_id'];
            let formData = [];
            for (let name of optionsName) {
                formData[name] = $(`select.${name} option:not([disabled]):selected`).val();
            }
            let id = $('#id').val();
            let windowUrl = config.url + `?id=${id}&order_id=${formData['order_id']}&customer_id=${formData['customer_id']}&store_id=${formData['store_id']}`;

            window.open(windowUrl, 'Email Template', "height=800,width=800");
        })
    }

});