'use strict';

const initPluginSettingsMenu = () => {
    const settingsMenu = jQuery('.ajax-error-logs-settings');
    if (!settingsMenu.length) return;

    const hideContainer = jQuery('.hide-in-settings');
    const settingsTabs = jQuery('.single-tab');
    const settingsDialogues = jQuery('.single-dialogue');
    const backToSettings = jQuery('.back-to-settings');

    settingsTabs.on('click', function () {
        const thisSettingsDomain = jQuery(this);
        const thisTargetID = thisSettingsDomain.attr('data-target');
        const thisTarget = jQuery('#' + thisTargetID);
        settingsDialogues.not(thisTarget).removeClass('active');
        thisTarget.addClass('active');
        hideContainer.addClass('active');
    });

    backToSettings.on('click', function () {
        settingsDialogues.removeClass('active');
        hideContainer.removeClass('active');
    });

    const triggerOtherSelect = jQuery('.trigger-other-select select');

    triggerOtherSelect.each(function () {
        const otherSelect = jQuery(this).parent().siblings('.show-when-active');
        if (jQuery(this).val() === 'true') {
            otherSelect.addClass('active');
        }
    });


    triggerOtherSelect.on('change', function () {
        const otherSelect = jQuery(this).parent().siblings('.show-when-active');
        otherSelect.removeClass('active');
        if (jQuery(this).val() === 'true') {
            otherSelect.addClass('active');
        }
    });
}

module.exports = {
    initPluginSettingsMenu
}