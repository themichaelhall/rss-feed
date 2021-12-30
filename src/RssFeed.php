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
use MichaelHall\RssFeed\Interfaces\RssImageInterface;
use MichaelHall\RssFeed\Interfaces\RssItemInterface;

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
        $this->myItems = [];
        $this->myFeedUrl = null;
        $this->myImage = null;
    }

    /**
     * Adds an item to the feed.
     *
     * @since 1.0.0
     *
     * @param RssItemInterface $item The item.
     */
    public function addItem(RssItemInterface $item): void
    {
        $this->myItems[] = $item;
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
     * Return the image or null if feed has no image.
     *
     * @since 2.1.0
     *
     * @return RssImageInterface|null The image or null if feed has no image.
     */
    public function getImage(): ?RssImageInterface
    {
        return $this->myImage;
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
     * Sets the feed url.
     *
     * @since 1.0.0
     *
     * @param UrlInterface $url The feed url.
     */
    public function setFeedUrl(UrlInterface $url): void
    {
        $this->myFeedUrl = $url;
    }

    /**
     * Sets the image.
     *
     * @since 2.1.0
     *
     * @param RssImageInterface $image The image.
     */
    public function setImage(RssImageInterface $image): void
    {
        $this->myImage = $image;
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
        $result = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"' . ($this->myFeedUrl !== null ? ' xmlns:atom="http://www.w3.org/2005/Atom"' : '') . '/>');

        $channel = $result->addChild('channel');
        $channel->addChild('title', self::encode($this->myTitle));
        $channel->addChild('link', self::encode($this->myLink->__toString()));
        $channel->addChild('description', self::encode($this->myDescription));

        if ($this->myFeedUrl !== null) {
            $atomLink = $channel->addChild('atom:atom:link');
            $atomLink->addAttribute('href', self::encode($this->myFeedUrl->__toString()));
            $atomLink->addAttribute('rel', 'self');
            $atomLink->addAttribute('type', 'application/rss+xml');
        }

        if ($this->myImage !== null) {
            self::addSimpleXmlChild($channel, $this->myImage->toXml());
        }

        foreach ($this->myItems as $item) {
            self::addSimpleXmlChild($channel, $item->toXml());
        }

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
     * Encodes a string.
     *
     * @param string $s The string.
     *
     * @return string The encoded string.
     */
    private static function encode(string $s): string
    {
        return str_replace('&', '&amp;', $s);
    }

    /**
     * Adds a SimpleXMLElement as a child to a root element.
     *
     * @param \SimpleXMLElement $root  The root element.
     * @param \SimpleXMLElement $child The child element.
     */
    private static function addSimpleXmlChild(\SimpleXMLElement $root, \SimpleXMLElement $child): void
    {
        $node = $root->addChild($child->getName(), (string) $child);

        foreach ($child->attributes() as $attributeName => $attributeValue) {
            $node->addAttribute($attributeName, (string) $attributeValue);
        }

        foreach ($child->children() as $c) {
            self::addSimpleXmlChild($node, $c);
        }
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

    /**
     * @var RssItemInterface[] My items.
     */
    private $myItems;

    /**
     * @var UrlInterface|null My feed url.
     */
    private $myFeedUrl;

    /**
     * @var RssImageInterface|null My image.
     */
    private $myImage;
}
