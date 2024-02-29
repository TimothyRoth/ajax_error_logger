'use strict';

/*
* Import Modules
* */

const {initErrorLogs} = require("./errorLogs/ajax/error_logs/errorLogs");
const {initSendMail} = require("./admin/sendMail");
const {initPluginSettingsMenu} = require("./admin/pluginSettingsMenu");
const {initLogFilter} = require("./admin/logFilter");
const {initBulkAction} = require("./admin/bulkAction");
const {initTestModule} = require("./errorLogs/ajax/error_logs/testModule/errorLogTestModule");

jQuery(document).ready(function () {
    initPluginSettingsMenu();
    initBulkAction();
    initLogFilter();
    initSendMail();
    initErrorLogs();
    initTestModule();
})
