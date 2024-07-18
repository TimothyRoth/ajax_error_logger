'use strict';

const {logFilter, filterQuery} = require("./logFilter");

const initBulkAction = () => {
    const bulkButton = jQuery('.select-all');
    if (!bulkButton.length) return;

    let selectAllToggle = false;

    jQuery('body').on('click', '.select-all', function ()   {
        const checkboxes = jQuery('input.select-single-log');
        checkboxes.prop('checked', !selectAllToggle);
        selectAllToggle = !selectAllToggle;
    });

    const bulkActionTrigger = jQuery('.bulk-action-button');
    const bulkActionSelect = jQuery('#bulk-action-select');

    bulkActionTrigger.on('click', function () {
        const action = bulkActionSelect.val();

        if (action === 'deleteLogs') {
            deleteLogs(getCheckedLogIDS());
        }

        if (action === 'exportLogs') {
            exportLogs(getCheckedLogIDS());
        }
    });
}

const getCheckedLogIDS = () => {
    const checkboxes = jQuery('input.select-single-log');
    const checkedCheckboxes = checkboxes.filter(':checked');
    const checkedLogIDS = checkedCheckboxes.map(function () {
        return jQuery(this).val();
    }).get();
    return checkedLogIDS;
}


const deleteLogs = logIDs => {
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax.url,
        data: {
            action: 'deleteLogs', logIDs: logIDs
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

const exportLogs = logIDs => {
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax.url,
        data: {
            action: 'exportLogs', logIDs: logIDs
        },
        success: function (ajaxResponse) {
            if (ajaxResponse.message)
                alert(ajaxResponse.message);

            if (ajaxResponse.file) {
                window.location.href = ajaxResponse.file;
                const checkboxes = jQuery('input.select-single-log');
                checkboxes.prop('checked', false);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}

module.exports = {
    initBulkAction
}