<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Setup;

use Magento\Framework\DB\Ddl\Table;
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
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    Config::TEMPLATE_NAME,
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Template Name'
                )
                ->addColumn(
                    Config::TEMPLATE_ID,
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Template ID'
                )
                ->addColumn(
                    Config::TEMPLATE_TYPE,
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Template Type'
                )
                ->setComment('Preview Email Table');
            $installer->getConnection()->createTable($table);

        }
        $installer->endSetup();
    }

}