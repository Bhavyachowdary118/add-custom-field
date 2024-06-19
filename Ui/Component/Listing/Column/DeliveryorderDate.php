<?php

namespace Kensium\Delivery\Ui\Component\Listing\Column;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class DeliveryorderDate extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;
    protected $_filterBuilder;
    protected $_timezone;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        FilterBuilder $filterBuilder,
        TimezoneInterface $timezone,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria = $criteria;
        $this->_filterBuilder = $filterBuilder;
        $this->_timezone = $timezone;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $order = $this->_orderRepository->get($item["entity_id"]);
                $date = $order->getData("delivery_date");
                
                if (!empty($date) && $date != '0000-00-00 00:00:00' && strtotime($date) !== false) {
                    // Format the date to display in "M d, Y" format
                    $formattedDate = date('M d, Y', strtotime($date));
                } else {

                    $formattedDate = 'N/A'; 
                }

                $item[$this->getData('name')] = $formattedDate;
            }
        }

        return $dataSource;
    }


}
