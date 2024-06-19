<?php
namespace Kensium\Delivery\Block;

use Magento\Framework\View\Element\Template;
use Kensium\Delivery\Model\ResourceModel\Delivery\CollectionFactory;

class Delivery extends Template
{
    protected $deliveryCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $deliveryCollectionFactory,
        array $data = []
    ) {
        $this->deliveryCollectionFactory = $deliveryCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getFormattedDeliveryDates()
    {
        $collection = $this->deliveryCollectionFactory->create();
        $dates = [];
        foreach ($collection as $item) {
            $dates[] = sprintf('%02d/%02d/%d', $item->getDeliveryMonth(), $item->getDeliveryDate(), $item->getDeliveryYear());
        }
        return $dates;
    }
}
?>
