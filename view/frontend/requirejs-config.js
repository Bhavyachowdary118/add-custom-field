var config = {
    config: {
        mixins: {
            'Magento_Ui/js/form/element/date': {
                'Kensium_Delivery/js/form/element/date-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
        	'Kensium_Delivery/js/order/place-order-mixin': true
            }           
        }
    }
};
