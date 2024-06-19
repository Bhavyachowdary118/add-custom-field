<?php
namespace Kensium\Delivery\Model\ResourceModel\Delivery;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Kensium\Delivery\Model\Delivery as DeliveryModel;
use Kensium\Delivery\Model\ResourceModel\Delivery as DeliveryResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(DeliveryModel::class, DeliveryResource::class);
    }
}
