define([
    'jquery',
    'mageUtils'
], function ($, utils) {
    'use strict';

    return function (target) {
        return target.extend({
            initialize: function () {
                this._super();

                var disabledDates = window.checkoutConfig.disabledDeliveryDates || [];
                console.log('Disabled dates:', disabledDates);

                this.options = Object.assign(this.options, {
                    minDate: 0,
                    dateFormat: 'mm/dd/yy',
                    beforeShowDay: function (date) {
                        var dateString = $.datepicker.formatDate('mm/dd/yy', date);
                        return [disabledDates.indexOf(dateString) === -1];
                    },
                    readonly: true,
                    onSelect: function (dateText) {
                        console.log('Selected date:', dateText);
                    }
                });

                return this;
            }
        });
    };
});
