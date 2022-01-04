<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Interfaces\UrlInterface;
use MichaelHall\RssFeed\Interfaces\RssItemInterface;

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
     * @param string             $title       The title.
     * @param UrlInterface       $link        The link.
     * @param string             $description The description.
     * @param \DateTimeImmutable $pubDate     The publication date.
     */
    public function __construct(string $title, UrlInterface $link, string $description, \DateTimeImmutable $pubDate)
    {
        $this->myTitle = $title;
        $this->myLink = $link;
        $this->myDescription = $description;
        $this->myPubDate = $pubDate;
        $this->myGuid = $link->__toString();
        $this->myGuidIsPermaLink = true;
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
     * Returns the GUID.
     *
     * @since 1.0.0
     *
     * @return string The GUID.
     */
    public function getGuid(): string
    {
        return $this->myGuid;
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
     * Returns the publication date.
     *
     * @since 1.0.0
     *
     * @return \DateTimeImmutable The publication date.
     */
    public function getPubDate(): \DateTimeImmutable
    {
        return $this->myPubDate;
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
     * Returns true if the GUID is a perma link, false otherwise.
     *
     * @since 1.0.0
     *
     * @return bool true if the GUID is a perma link, false otherwise.
     */
    public function isGuidPermaLink(): bool
    {
        return $this->myGuidIsPermaLink;
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
        $this->myGuid = $guid;
        $this->myGuidIsPermaLink = $isPermaLink;
    }

    /**
     * Returns the item as an XML node.
     *
     * @since 1.0.0
     *
     * @return \SimpleXMLElement The XML node.
     */
    public function toXml(): \SimpleXMLElement
    {
        $result = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><item/>');
        $result->addChild('title', self::encode($this->myTitle));
        $result->addChild('link', self::encode($this->myLink->__toString()));
        $result->addChild('description', self::encode($this->myDescription));
        $result->addChild('pubDate', self::encode($this->myPubDate->format(\DATE_RSS)));
        $result->addChild('guid', self::encode($this->myGuid))->addAttribute('isPermaLink', $this->myGuidIsPermaLink ? 'true' : 'false');

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
     * @var string My description.
     */
    private $myDescription;

    /**
     * @var UrlInterface My link.
     */
    private $myLink;

    /**
     * @var \DateTimeImmutable My publication date.
     */
    private $myPubDate;

    /**
     * @var string My title.
     */
    private $myTitle;

    /**
     * @var string My GUID.
     */
    private $myGuid;

    /**
     * @var bool True if GUID is perma link, false otherwise.
     */
    private $myGuidIsPermaLink;
}
