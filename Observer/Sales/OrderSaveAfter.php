<?php
namespace Kensium\Delivery\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderSaveAfter implements ObserverInterface
{
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $order->save();
        
    }
}
