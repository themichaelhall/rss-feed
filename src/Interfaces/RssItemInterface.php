<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed\Interfaces;

use DataTypes\Net\UrlInterface;
use DateTimeImmutable;
use SimpleXMLElement;
use Stringable;

/**
 * Interface representing an RSS item.
 *
 * @since 1.0.0
 */
interface RssItemInterface extends Stringable
{
    /**
     * Returns the description.
     *
     * @since 1.0.0
     *
     * @return string The description.
     */
    public function getDescription(): string;

    /**
     * Returns the GUID.
     *
     * @since 1.0.0
     *
     * @return string The GUID.
     */
    public function getGuid(): string;

    /**
     * Returns the link.
     *
     * @since 1.0.0
     *
     * @return UrlInterface The link.
     */
    public function getLink(): UrlInterface;

    /**
     * Returns the publication date.
     *
     * @since 1.0.0
     *
     * @return DateTimeImmutable The publication date.
     */
    public function getPubDate(): DateTimeImmutable;

    /**
     * Returns the title.
     *
     * @since 1.0.0
     *
     * @return string The title.
     */
    public function getTitle(): string;

    /**
     * Returns true if the GUID is a perma link, false otherwise.
     *
     * @since 1.0.0
     *
     * @return bool true if the GUID is a perma link, false otherwise.
     */
    public function isGuidPermaLink(): bool;

    /**
     * Sets the GUID.
     *
     * @since 1.0.0
     *
     * @param string $guid        The GUID.
     * @param bool   $isPermaLink True if GUID is a perma link, false otherwise.
     */
    public function setGuid(string $guid, bool $isPermaLink = false): void;

    /**
     * Returns the item as an XML node.
     *
     * @since 1.0.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement;
}
