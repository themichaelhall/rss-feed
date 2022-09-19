<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Net\UrlInterface;
use MichaelHall\RssFeed\Interfaces\RssFeedInterface;
use MichaelHall\RssFeed\Interfaces\RssImageInterface;
use MichaelHall\RssFeed\Interfaces\RssItemInterface;
use SimpleXMLElement;

/**
 * Class representing an RSS feed.
 *
 * @since 1.0.0
 */
class RssFeed implements RssFeedInterface
{
    /**
     * Constructs an RSS feed.
     *
     * @since 1.0.0
     *
     * @param string       $title       The title.
     * @param UrlInterface $link        The link.
     * @param string       $description The description.
     */
    public function __construct(string $title, UrlInterface $link, string $description)
    {
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->items = [];
        $this->feedUrl = null;
        $this->image = null;
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
        $this->items[] = $item;
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
        return $this->description;
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
        return $this->image;
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
        return $this->link;
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
        return $this->title;
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
        $this->feedUrl = $url;
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
        $this->image = $image;
    }

    /**
     * Returns the feed as an XML node.
     *
     * @since 1.0.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement
    {
        $result = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"' . ($this->feedUrl !== null ? ' xmlns:atom="http://www.w3.org/2005/Atom"' : '') . '/>');

        $channel = $result->addChild('channel');
        $channel->addChild('title', self::encode($this->title));
        $channel->addChild('link', self::encode($this->link->__toString()));
        $channel->addChild('description', self::encode($this->description));

        if ($this->feedUrl !== null) {
            $atomLink = $channel->addChild('atom:atom:link');
            $atomLink->addAttribute('href', self::encode($this->feedUrl->__toString()));
            $atomLink->addAttribute('rel', 'self');
            $atomLink->addAttribute('type', 'application/rss+xml');
        }

        if ($this->image !== null) {
            self::addSimpleXmlChild($channel, $this->image->toXml());
        }

        foreach ($this->items as $item) {
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
     * @param SimpleXMLElement $root  The root element.
     * @param SimpleXMLElement $child The child element.
     */
    private static function addSimpleXmlChild(SimpleXMLElement $root, SimpleXMLElement $child): void
    {
        $node = $root->addChild($child->getName(), strval($child));

        foreach ($child->attributes() as $attributeName => $attributeValue) {
            $node->addAttribute($attributeName, strval($attributeValue));
        }

        foreach ($child->children() as $c) {
            self::addSimpleXmlChild($node, $c);
        }
    }

    /**
     * @var string The description.
     */
    private string $description;

    /**
     * @var UrlInterface The link.
     */
    private UrlInterface $link;

    /**
     * @var string The title.
     */
    private string $title;

    /**
     * @var RssItemInterface[] The items.
     */
    private array $items;

    /**
     * @var UrlInterface|null The feed url.
     */
    private ?UrlInterface $feedUrl;

    /**
     * @var RssImageInterface|null The image.
     */
    private ?RssImageInterface $image;
}
