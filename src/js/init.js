'use strict';

/*
* Import Modules
* */

const {initErrorLogs} = require("./errorLogs/ajax/error_logs/errorLogs");
const {initSendMail} = require("./admin/sendMail");
const {initPluginSettingsMenu} = require("./admin/pluginSettingsMenu");
const {initLogFilter} = require("./admin/logFilter");
const {initBulkAction} = require("./admin/bulkAction");

jQuery(document).ready(function () {
    initPluginSettingsMenu();
    initBulkAction();
    initLogFilter();
    initSendMail();
    initErrorLogs();
})
