<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed\Interfaces;

use DataTypes\Net\UrlInterface;
use SimpleXMLElement;
use Stringable;

/**
 * Interface representing an RSS feed.
 *
 * @since 1.0.0
 */
interface RssFeedInterface extends Stringable
{
    /**
     * Adds an item to the feed.
     *
     * @since 1.0.0
     *
     * @param RssItemInterface $item The item.
     */
    public function addItem(RssItemInterface $item): void;

    /**
     * Returns the description.
     *
     * @since 1.0.0
     *
     * @return string The description.
     */
    public function getDescription(): string;

    /**
     * Return the image or null if feed has no image.
     *
     * @since 2.1.0
     *
     * @return RssImageInterface|null The image or null if feed has no image.
     */
    public function getImage(): ?RssImageInterface;

    /**
     * Returns the link.
     *
     * @since 1.0.0
     *
     * @return UrlInterface The link.
     */
    public function getLink(): UrlInterface;

    /**
     * Returns the title.
     *
     * @since 1.0.0
     *
     * @return string The title.
     */
    public function getTitle(): string;

    /**
     * Sets the feed url.
     *
     * @since 1.0.0
     *
     * @param UrlInterface $url The feed url.
     */
    public function setFeedUrl(UrlInterface $url): void;

    /**
     * Sets the image.
     *
     * @since 2.1.0
     *
     * @param RssImageInterface $image The image.
     */
    public function setImage(RssImageInterface $image): void;

    /**
     * Returns the item as an XML node.
     *
     * @since 1.0.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement;
}
