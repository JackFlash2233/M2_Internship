<?php


namespace MagManager\DBManager\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class DBActions extends Column
{
    private $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['view_table'] = [
                    'href' => $this->urlBuilder->getUrl('dbmanager/index/view', ['table_name' => $item['table_name']]),
                    'label' => __('View Table'),
                    'hidden' => false
                ];
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl('dbmanager/index/edit', ['table_name' => $item['table_name']]),
                    'label' => __('Edit'),
                    'hidden' => false
                ];
//                $item[$this->getData('name')]['delete'] = [
//                    'href' => $this->urlBuilder->getUrl('dbmanager/index/delete', ['id' => $item['entity_id']]),
//                    'label' => __('Delete'),
//                    'hidden' => false
//                ];
            }
        }

        return $dataSource;
    }
}
