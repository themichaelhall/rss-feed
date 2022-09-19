<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Net\UrlInterface;
use MichaelHall\RssFeed\Interfaces\RssImageInterface;
use SimpleXMLElement;

/**
 * Class representing an RSS image.
 *
 * @since 2.1.0
 */
class RssImage implements RssImageInterface
{
    /**
     * Constructs an RSS item.
     *
     * @since 2.1.0
     *
     * @param UrlInterface $url   The url.
     * @param string       $title The title.
     * @param UrlInterface $link  The link.
     */
    public function __construct(UrlInterface $url, string $title, UrlInterface $link)
    {
        $this->url = $url;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Returns the link.
     *
     * @since 2.1.0
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
     * @since 2.1.0
     *
     * @return string The title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the url.
     *
     * @since 2.1.0
     *
     * @return UrlInterface The url.
     */
    public function getUrl(): UrlInterface
    {
        return $this->url;
    }

    /**
     * Returns the image as an XML node.
     *
     * @since 2.1.0
     *
     * @return SimpleXMLElement The XML node.
     */
    public function toXml(): SimpleXMLElement
    {
        $result = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><image/>');
        $result->addChild('url', self::encode($this->url->__toString()));
        $result->addChild('title', self::encode($this->title));
        $result->addChild('link', self::encode($this->link->__toString()));

        return $result;
    }

    /**
     * Returns the image as a string.
     *
     * @since 2.1.0
     *
     * @return string The image as a string.
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
     * @var UrlInterface The url.
     */
    private UrlInterface $url;

    /**
     * @var string The title.
     */
    private string $title;

    /**
     * @var UrlInterface The link.
     */
    private UrlInterface $link;
}
