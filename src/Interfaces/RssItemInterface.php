<?php
/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */
declare(strict_types=1);

namespace MichaelHall\RssFeed\Interfaces;

use DataTypes\Interfaces\UrlInterface;

/**
 * Interface representing a RSS item.
 *
 * @since 1.0.0
 */
interface RssItemInterface
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
     * @return \DateTimeImmutable The publication date.
     */
    public function getPubDate(): \DateTimeImmutable;

    /**
     * Returns the title.
     *
     * @since 1.0.0
     *
     * @return string The title.
     */
    public function getTitle(): string;

    /**
     * Returns the item as an XML node.
     *
     * @since 1.0.0
     *
     * @return \SimpleXMLElement The XML node.
     */
    public function toXml(): \SimpleXMLElement;

    /**
     * Returns the item as a string.
     *
     * @since 1.0.0
     *
     * @return string The item as a string.
     */
    public function __toString(): string;
}
