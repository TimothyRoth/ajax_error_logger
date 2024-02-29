'use strict';

const initErrorLogs = () => {
    jQuery(document).ajaxError(function (event, jqxhr, settings, thrownError) {

        const errorLog = {
            errorMsg: thrownError || jqxhr.statusText,
            httpStatus: jqxhr.status,
            requestMethod: settings.type,
            requestData: settings.data, // Be cautious with sensitive info
            timestamp: formatDate(new Date())
        };

        try {
            sendErrorLog(errorLog);
        } catch (e) {
            console.error('Error Log could not be sent');
        }

    });
}

const formatDate = (date) => {
    const formattedDate = date.getFullYear() + '-' +
        ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
        ('0' + date.getDate()).slice(-2) + ' ' +
        ('0' + date.getHours()).slice(-2) + ':' +
        ('0' + date.getMinutes()).slice(-2) + ':' +
        ('0' + date.getSeconds()).slice(-2);

    return formattedDate;
}
const sendErrorLog = errorLog => {

    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'writeErrorLog', errorLog
        }, beforeSend: function () {
            // .. no actions required
        }, success: function () {
            // .. no actions required
        }, complete: function () {
            console.log("This error was logged: ", errorLog);
            sendLogsAtThreshold();
        }
    });
}

const sendLogsAtThreshold = () => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'sendLogsAtThreshold'
        }, beforeSend: function () {
            // .. no actions required
        }, success: function (response) {
            console.log(response.message);
        }, complete: function () {
            // .. no actions required
        }
    });
}

module.exports = {
    initErrorLogs
}

