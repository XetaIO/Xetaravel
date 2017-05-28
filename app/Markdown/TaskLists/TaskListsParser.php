<?php
namespace Xetaravel\Markdown\TaskLists;

use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Delimiter\Delimiter;

class TaskListsParser extends AbstractInlineParser
{
    /**
     * Get the characters that must be matched.
     *
     * @return array
     */
    public function getCharacters()
    {
        return [' ', 'x'];
    }

    /**
     * Parse a line and determine if it contains a checkbox. If it does,
     * then we replace it by some HTML elements and customized for bootstrap 4.
     *
     * @param \League\CommonMark\InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor         = $inlineContext->getCursor();
        $delimiterStack = $inlineContext->getDelimiterStack();

        if ($cursor->peek(-1) !== '[') {
            return false;
        }

        if ($cursor->peek(-2) == '!' ||
            $cursor->peek(-1) !== '[' ||
            $cursor->peek(1) !== ']' ||
            $cursor->peek(2) !== ' '
        ) {
            return false;
        }

        $status = $cursor->peek(0) == 'x';

        $cursor->advanceBy(2);

        // Add entry to stack for this opener
        $delimiter = new Delimiter('[', 1, $inlineContext->getContainer()->firstChild(), true, false, 0);
        $delimiterStack->push($delimiter);

        $opener = $delimiterStack->searchByCharacter(['[']);
        $text = $cursor->match('/\S(.*)/');
        $opener->getInlineNode()->replaceWith(new TaskListsCheckbox($status, ['text' => $text]));

        $delimiterStack->removeDelimiter($opener);

        return true;
    }
}
