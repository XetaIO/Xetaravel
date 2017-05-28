<?php
namespace Xetaravel\Markdown\Table;

use League\CommonMark\Extension\Extension;
use Webuni\CommonMark\TableExtension\TableCaptionRenderer;
use Webuni\CommonMark\TableExtension\TableRowsRenderer;
use Webuni\CommonMark\TableExtension\TableRowRenderer;
use Webuni\CommonMark\TableExtension\TableCellRenderer;
use Webuni\CommonMark\TableExtension\TableParser;

class TableExtension extends Extension
{
    /**
     * Returns a list of block parsers to add to the existing list.
     *
     * @return array
     */
    public function getBlockParsers()
    {
        return [
            new TableParser(),
        ];
    }

    /**
     * Returns a list of block renderers to add to the existing list.
     *
     * @return array
     */
    public function getBlockRenderers()
    {
        return [
            \Webuni\CommonMark\TableExtension\Table::class => new TableRenderer(),
            \Webuni\CommonMark\TableExtension\TableCaption::class => new TableCaptionRenderer(),
            \Webuni\CommonMark\TableExtension\TableRows::class => new TableRowsRenderer(),
            \Webuni\CommonMark\TableExtension\TableRow::class => new TableRowRenderer(),
            \Webuni\CommonMark\TableExtension\TableCell::class => new TableCellRenderer(),
        ];
    }
}
