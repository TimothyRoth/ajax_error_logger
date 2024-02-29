'use strict';

const initTestModule = () => {
    testModule();
}
const testModule = () => {

    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'testModuleNotFound',
        }, beforeSend: function () {
            // .. Test Module
        }, success: function (ajaxResponse) {
            // .. Test Module // Produces Error Type 500
            console.log(ajaxResponse)
        }, complete: function () {
            // .. Test Module
        }
    });
}

module.exports = {
    initTestModule
}

