'use strict';

let filterQuery = {
    posts_per_page: 10,
};

const initLogFilter = () => {
    const filter = jQuery('.log-filter');
    if (filter.length === 0) return;

    const selects = filter.find('select');
    const viewCounter =

        selects.on('change', function () {
            filterQuery.post_status = selects.filter('select[name="log-filter-by-status"]').val();
            filterQuery.order = selects.filter('select[name="log-filter-by-order"]').val();
            filterQuery.posts_per_page = parseInt(selects.filter('select[name="log-filter-amount"]').val());
            logFilter(filterQuery);
        });
}
const logFilter = filterQuery => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'logFilter', filterQuery
        }, beforeSend: function () {
            // .. no actions required
        }, success: function (response) {
            const container = jQuery('.ajax-error-logs-log-container tbody');
            const currentViews = jQuery('span#current-view');
            const totalViews = jQuery('span#total-view');
            container.html(response.html);
            currentViews.text(response.current);
            totalViews.text(response.total);
        }, complete: function () {
            // .. no actions required
        }
    });
}

module.exports = {
    initLogFilter,
    logFilter,
    filterQuery
}
