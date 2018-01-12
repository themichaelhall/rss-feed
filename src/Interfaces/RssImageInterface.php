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
 * Interface representing a RSS image.
 *
 * @since 2.1.0
 */
interface RssImageInterface
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
     * @return \SimpleXMLElement The XML node.
     */
    public function toXml(): \SimpleXMLElement;

    /**
     * Returns the image as a string.
     *
     * @since 2.1.0
     *
     * @return string The image as a string.
     */
    public function __toString(): string;
}
