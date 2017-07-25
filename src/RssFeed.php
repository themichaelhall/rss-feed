<?php
/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */
declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Interfaces\UrlInterface;
use MichaelHall\RssFeed\Interfaces\RssFeedInterface;

/**
 * Class representing a RSS feed.
 *
 * @since 1.0.0
 */
class RssFeed implements RssFeedInterface
{
    /**
     * Constructs a RSS feed.
     *
     * @since 1.0.0
     *
     * @param string       $title       The title.
     * @param UrlInterface $link        The link.
     * @param string       $description The description.
     */
    public function __construct(string $title, UrlInterface $link, string $description)
    {
        $this->myTitle = $title;
        $this->myLink = $link;
        $this->myDescription = $description;
    }

    /**
     * Returns the description.
     *
     * @since 1.0.0
     *
     * @return string The description.
     */
    public function getDescription(): string
    {
        return $this->myDescription;
    }

    /**
     * Returns the link.
     *
     * @since 1.0.0
     *
     * @return UrlInterface The link.
     */
    public function getLink(): UrlInterface
    {
        return $this->myLink;
    }

    /**
     * Returns the title.
     *
     * @since 1.0.0
     *
     * @return string The title.
     */
    public function getTitle(): string
    {
        return $this->myTitle;
    }

    /**
     * Returns the feed as an XML node.
     *
     * @since 1.0.0
     *
     * @return \SimpleXMLElement The XML node.
     */
    public function toXml(): \SimpleXMLElement
    {
        $result = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"/>');

        $channel = $result->addChild('channel');
        $channel->addChild('title', $this->myTitle);
        $channel->addChild('link', $this->myLink->__toString());
        $channel->addChild('description', $this->myDescription);

        return $result;
    }

    /**
     * Returns the feed as a string.
     *
     * @since 1.0.0
     *
     * @return string The feed as a string.
     */
    public function __toString(): string
    {
        return $this->toXml()->asXML();
    }

    /**
     * @var string My description.
     */
    private $myDescription;

    /**
     * @var UrlInterface My link.
     */
    private $myLink;

    /**
     * @var string My title.
     */
    private $myTitle;
}
