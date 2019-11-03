<?php
namespace Xetaravel\Markdown\Table;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Ext\Table\Table;
use League\CommonMark\Ext\Table\TableParser;
use League\CommonMark\Ext\Table\TableCaption;
use League\CommonMark\Ext\Table\TableCaptionRenderer;
use League\CommonMark\Ext\Table\TableSection;
use League\CommonMark\Ext\Table\TableSectionRenderer;
use League\CommonMark\Ext\Table\TableRow;
use League\CommonMark\Ext\Table\TableRowRenderer;
use League\CommonMark\Ext\Table\TableCell;
use League\CommonMark\Ext\Table\TableCellRenderer;

final class TableExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        $environment
            ->addBlockParser(new TableParser())
            ->addBlockRenderer(Table::class, new TableRenderer())
            ->addBlockRenderer(TableCaption::class, new TableCaptionRenderer())
            ->addBlockRenderer(TableSection::class, new TableSectionRenderer())
            ->addBlockRenderer(TableRow::class, new TableRowRenderer())
            ->addBlockRenderer(TableCell::class, new TableCellRenderer())
        ;
    }
}
