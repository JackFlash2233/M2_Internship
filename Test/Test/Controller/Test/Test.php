<?php

namespace Test\Test\Controller\Test;

use Magento\Catalog\Controller\Product as ProductAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Zend_Db_Expr;

class Test extends ProductAction implements HttpGetActionInterface, HttpPostActionInterface
{
//    /**
//     * @var PageFactory
//     */
    private $pageFactory;

    /**
     * @var AdapterInterface
     */
    private $connection;

    /**
     * @inheritDoc
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->connection = $resourceConnection->getConnection();
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $cpe = $this->connection->getTableName('catalog_product_entity');
        $ea = $this->connection->getTableName('eav_attribute');
        $cpei = $this->connection->getTableName('catalog_product_entity_int');
        $cpev = $this->connection->getTableName('catalog_product_entity_varchar');
        $eaov = $this->connection->getTableName('eav_attribute_option_value');

        $name = $this->connection->select()
            ->from($ea, ['attribute_id'])
            ->where(new Zend_Db_Expr($ea . '.attribute_code = \'name\' AND entity_type_id = 4'));

        $color = $this->connection->select()
            ->from($ea, ['attribute_id'])
            ->where(new Zend_Db_Expr($ea . '.attribute_code = \'color\' AND entity_type_id = 4'));

        $select = $this->connection->select()
            ->from(
                ['cpe' => $cpe],
                ['cpe.entity_id',
                    'cpe.sku',
                    'name' => 'cpev.value',
                    'color' => 'eaov.value'
                ]
            )
            ->join(['cpev' => $cpev], 'cpev.entity_id = cpe.entity_id and cpev.attribute_id = (' . $name . ')', [])
            ->join(['cpei' => $cpei], 'cpei.entity_id = cpe.entity_id and cpei.attribute_id = (' . $color . ')', [])
            ->join(['eaov' => $eaov], 'cpei.value = eaov.option_id', []);

        $this->connection->fetchAll($name);
        $this->connection->fetchAll($color);
        $this->connection->fetchAll($select);

        return $this->pageFactory->create();
    }
}
