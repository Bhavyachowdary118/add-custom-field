<?php

namespace Kensium\Delivery\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderRepositoryPlugin
{
    protected $extensionFactory;

    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->extensionFactory->create();
        }

        $extensionAttributes->setDeliveryDate($order->getData('delivery_date'));
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    public function afterGetList(OrderRepositoryInterface $subject, $result)
    {
        foreach ($result->getItems() as $order) {
            $this->afterGet($subject, $order);
        }
        return $result;
    }

    public function beforeSave(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes !== null && $extensionAttributes->getDeliveryDate() !== null) {
            $order->setData('delivery_date', $extensionAttributes->getDeliveryDate());
        }
    }
}
