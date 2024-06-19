<?php

namespace Kensium\Delivery\Block\Adminhtml\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;

class DeliveryDate extends Template
{
    protected $order;

    public function __construct(
        Context $context,
        Order $order,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->order = $order;
    }

    public function getOrderDeliveryDate()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $order = $this->order->load($orderId);
        $deliveryDate = $order->getDeliveryDate();
        
        // Format delivery date
        return $this->formatDeliveryDate($deliveryDate);
    }

    private function formatDeliveryDate($deliveryDate)
    {
        return date('M d, Y', strtotime($deliveryDate));
    }
}
