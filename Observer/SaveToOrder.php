<?php
namespace Kensium\Delivery\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Psr\Log\LoggerInterface;

class SaveToOrder implements ObserverInterface
{   
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $this->logger->info('SaveToOrder Observer executed'); 

        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        if ($order && $quote) {
            $this->logger->info('Order ID: ' . $order->getId());
            $this->logger->info('Quote ID: ' . $quote->getId());

            $deliveryDateFromQuote = $quote->getData('delivery_date');
            $this->logger->info('Delivery Date from Quote: ' . $deliveryDateFromQuote);

            // Save data to sales_order table
            $order->setData('delivery_date', $deliveryDateFromQuote);
            $this->orderRepository->save($order);

            $this->logger->info('Delivery Date saved to Order ID: ' . $order->getId());

            // Save data to sales_order_grid table
            $orderGrid = $this->orderRepository->get($order->getId());
            $orderGrid->setDeliveryDate($deliveryDateFromQuote);
            $this->orderRepository->save($orderGrid);

            $this->logger->info('Delivery Date saved to Order Grid for Order ID: ' . $order->getId());

            // Save data to quote table
            $quote->setData('delivery_date', $order->getData('delivery_date'));
            $this->cartRepository->save($quote);

            $this->logger->info('Delivery Date saved to Quote ID: ' . $quote->getId());
        } else {
            if (!$order) {
                $this->logger->error('Order object is not available in the observer.');
            }
            if (!$quote) {
                $this->logger->error('Quote object is not available in the observer.');
            }
        }
    }

    protected function updateOrderGrid(OrderInterface $order)
    {
        $this->logger->info('Updating Order Grid for Order ID: ' . $order->getId());
        
        $orderGrid = $this->orderRepository->get($order->getId());
        $orderGrid->setDeliveryDate($order->getData('delivery_date'));
        $this->orderRepository->save($orderGrid);
        
        $this->logger->info('Delivery Date updated in Order Grid for Order ID: ' . $order->getId());
    }
}
