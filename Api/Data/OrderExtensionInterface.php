<?php

namespace Kensium\Delivery\Api\Data;

interface OrderExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * Get delivery date
     *
     * @return string|null
     */
    public function getDeliveryDate();

    /**
     * Set delivery date
     *
     * @param string $deliveryDate
     * @return $this
     */
    public function setDeliveryDate($deliveryDate);
}
