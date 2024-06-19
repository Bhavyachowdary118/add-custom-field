<?php
namespace Kensium\Delivery\Model;

use Magento\Framework\Model\AbstractModel;

class Delivery extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Kensium\Delivery\Model\ResourceModel\Delivery');
    }
}
