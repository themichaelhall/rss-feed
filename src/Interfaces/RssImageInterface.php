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
 * Interface representing an RSS image.
 *
 * @since 2.1.0
 */
interface RssImageInterface extends Stringable
{
    /**
     * Returns the link.
     *
     * @since 2.1.0
     *
     * @return UrlInterface The link.
     */
    public function getLink(): UrlInterface;

    /**
     * Returns the title.
     *
     * @since 2.1.0
     *
     * @return string The title.
     */
    public function getTitle(): string;

    /**
     * Returns the url.
     *
     * @since 2.1.0
     *
     * @return UrlInterface The url.
     */
    public function getUrl(): UrlInterface;

    /**
     * Returns the image as an XML node.
     *
     * @since 2.1.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement;
}
