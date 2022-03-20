<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class Reply extends AbstractBlock
{
    /**
     * The route used to display the post.
     *
     * @var string
     */
    protected $route;

    /**
     * The user of the reply.
     *
     * @var string
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param string $route The route used to display the post.
     * @param string $user The user of the reply.
     */
    public function __construct(string $route, string $user)
    {
        $this->route = $route;
        $this->user = $user;
    }

    /**
     * Get the route.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get the user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns true if this block can contain the given block as a child node
     *
     * @param AbstractBlock $block
     *
     * @return bool
     */
    public function canContain(AbstractBlock $block): bool
    {
        return false;
    }

    /**
     * Returns true if block type can accept lines of text
     *
     * @return bool
     */
    public function acceptsLines(): bool
    {
        return true;
    }

    /**
     * Whether this is a code block
     *
     * @return bool
     */
    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return false;
    }
}
