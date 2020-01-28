<?php


namespace Overdose\PreviewEmail\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface as Config;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists(Config::TABLE_NAME)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(Config::TABLE_NAME)
            )
                ->addColumn(
                    Config::ID,
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Preview Template ID'
                )
                ->addColumn(
                    Config::TYPE,
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Preview Template Type'
                )
                ->addColumn(
                    Config::FIELDS,
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Preview Template Fields'
                )
                ->addColumn(
                    Config::NAME,
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Preview Type Name'
                )
                ->addColumn(
                    Config::CONFIG_PATH,
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'System Config Path'
                )
                ->setComment('Preview Email Template Name');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}