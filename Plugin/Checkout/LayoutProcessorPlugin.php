<?php
namespace Kensium\Delivery\Plugin\Checkout;

class LayoutProcessorPlugin
{
    protected $deliveryBlock;

    public function __construct(\Kensium\Delivery\Block\Delivery $deliveryBlock)
    {
        $this->deliveryBlock = $deliveryBlock;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        // Fetch disabled dates from the Delivery Block
        $disabledDates = $this->deliveryBlock->getFormattedDeliveryDates();

        // JavaScript function to disable specific dates
        $disableSpecificDatesJs = new \Zend\Json\Expr("
            function(date) {
                var disabledDates = " . \Zend\Json\Json::encode($disabledDates) . ";
                var dateString = jQuery.datepicker.formatDate('mm/dd/yy', date);
                if (disabledDates.indexOf(dateString) !== -1) {
                    return [false];
                }
                return [true];
            }
        ");

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-form']['children']['delivery_date'] = [
            'component' => 'Magento_Ui/js/form/element/date',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'Kensium_Delivery/form/element/delivery-date', // Custom template path
                'options' => [
                    'minDate' => '0',
                    'dateFormat' => 'mm/dd/yy',
                    'beforeShowDay' => $disableSpecificDatesJs,
                ],
                'id' => 'delivery_date'
            ],
            'dataScope' => 'shippingAddress.delivery_date',
            'label' => __('Delivery Date'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 200,
            'id' => 'delivery_date',
            'readonly' => true
        ];

        return $jsLayout;
    }
}
