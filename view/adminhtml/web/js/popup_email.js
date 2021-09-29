define([
    'jquery'
], function ($) {
    'use strict';

    return function (config) {
        $('#popup-submit').on('click', function () {
            let optionsName = ['preview_template_id', 'order_id', 'customer_id', 'creditmemo_id', 'password_reset', 'contact_form', 'subscription_success', 'store_id'];
            let formData = [];
            for (let name of optionsName) {
                formData[name] = $(`select.${name} option:not([disabled]):selected`).val();
            }
            let id = $('#preview_template_id').val();
            let windowUrl = config.url + `?preview_template_id=${id}&order_id=${formData['order_id']}&customer_id=${formData['customer_id']}&store_id=${formData['store_id']}&creditmemo_id=${formData['creditmemo_id']}&password_reset=${formData['password_reset']}&contact_form=${formData['contact_form']}&subscription_success=${formData['subscription_success']}`;

            window.open(windowUrl, 'Email Template', "height=800,width=800");
        })
    }
});
