<?php

namespace Kensium\Delivery\Model;

use Kensium\Delivery\Api\Data\OrderExtensionInterface;

class OrderExtension extends \Magento\Framework\Api\AbstractExtensibleObject implements OrderExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDeliveryDate()
    {
        return $this->_get('delivery_date');
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliveryDate($deliveryDate)
    {
        return $this->setData('delivery_date', $deliveryDate);
    }
}
