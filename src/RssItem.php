<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Net\UrlInterface;
use DateTimeImmutable;
use MichaelHall\RssFeed\Interfaces\RssItemInterface;
use SimpleXMLElement;

/**
 * Class representing an RSS item.
 *
 * @since 1.0.0
 */
class RssItem implements RssItemInterface
{
    /**
     * Constructs an RSS item.
     *
     * @since 1.0.0
     *
     * @param string            $title       The title.
     * @param UrlInterface      $link        The link.
     * @param string            $description The description.
     * @param DateTimeImmutable $pubDate     The publication date.
     */
    public function __construct(string $title, UrlInterface $link, string $description, DateTimeImmutable $pubDate)
    {
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->pubDate = $pubDate;
        $this->guid = $link->__toString();
        $this->guidIsPermaLink = true;
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
     * Returns the GUID.
     *
     * @since 1.0.0
     *
     * @return string The GUID.
     */
    public function getGuid(): string
    {
        return $this->guid;
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
     * Returns the publication date.
     *
     * @since 1.0.0
     *
     * @return DateTimeImmutable The publication date.
     */
    public function getPubDate(): DateTimeImmutable
    {
        return $this->pubDate;
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
     * Returns true if the GUID is a perma link, false otherwise.
     *
     * @since 1.0.0
     *
     * @return bool true if the GUID is a perma link, false otherwise.
     */
    public function isGuidPermaLink(): bool
    {
        return $this->guidIsPermaLink;
    }

    /**
     * Sets the GUID.
     *
     * @since 1.0.0
     *
     * @param string $guid        The GUID.
     * @param bool   $isPermaLink True if GUID is a perma link, false otherwise.
     */
    public function setGuid(string $guid, bool $isPermaLink = false): void
    {
        $this->guid = $guid;
        $this->guidIsPermaLink = $isPermaLink;
    }

    /**
     * Returns the item as an XML node.
     *
     * @since 1.0.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement
    {
        $result = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><item/>');
        $result->addChild('title', self::encode($this->title));
        $result->addChild('link', self::encode($this->link->__toString()));
        $result->addChild('description', self::encode($this->description));
        $result->addChild('pubDate', self::encode($this->pubDate->format(DATE_RSS)));
        $result->addChild('guid', self::encode($this->guid))->addAttribute('isPermaLink', $this->guidIsPermaLink ? 'true' : 'false');

        return $result;
    }

    /**
     * Returns the item as a string.
     *
     * @since 1.0.0
     *
     * @return string The item as a string.
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
     * @var string The description.
     */
    private $description;

    /**
     * @var UrlInterface The link.
     */
    private $link;

    /**
     * @var DateTimeImmutable The publication date.
     */
    private $pubDate;

    /**
     * @var string The title.
     */
    private $title;

    /**
     * @var string The GUID.
     */
    private $guid;

    /**
     * @var bool True if GUID is perma link, false otherwise.
     */
    private $guidIsPermaLink;
}
