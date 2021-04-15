<?php


namespace JackFlash\Blog\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();
        $connection->addColumn(
            $setup->getTable('eav_attribute_option'),
            'is_enabled',
            [
                'type' => Table::TYPE_SMALLINT,
                'length' => 1,
                'nullable' => true,
                'default' => '1',
                'comment' => 'Is Enabled'
            ]
        );
    }
}
