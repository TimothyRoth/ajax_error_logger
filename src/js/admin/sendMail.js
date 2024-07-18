'use strict';

const {logFilter, filterQuery} = require("./logFilter");

const initSendMail = () => {
    const button = jQuery('.trigger-send-mail');
    button.on('click', function () {
        sendMail();
    });
}

const sendMail = () => {
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax.url,
        data: {
            action: 'sendMail'
        },
        success: function (ajaxResponse) {
            alert(ajaxResponse.message);
        },
        complete: function () {
            logFilter(filterQuery);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}

module.exports = {
    initSendMail,
};