<?php

/**
 * This file is a part of the rss-feed package.
 *
 * Read more at https://github.com/themichaelhall/rss-feed
 */

declare(strict_types=1);

namespace MichaelHall\RssFeed;

use DataTypes\Interfaces\UrlInterface;
use MichaelHall\RssFeed\Interfaces\RssImageInterface;

/**
 * Class representing a RSS image.
 *
 * @since 2.1.0
 */
class RssImage implements RssImageInterface
{
    /**
     * Constructs a RSS item.
     *
     * @since 2.1.0
     *
     * @param UrlInterface $url   The url.
     * @param string       $title The title.
     * @param UrlInterface $link  The link.
     */
    public function __construct(UrlInterface $url, string $title, UrlInterface $link)
    {
        $this->myUrl = $url;
        $this->myTitle = $title;
        $this->myLink = $link;
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
        return $this->myLink;
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
        return $this->myTitle;
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
        return $this->myUrl;
    }

    /**
     * Returns the image as an XML node.
     *
     * @since 2.1.0
     *
     * @return \SimpleXMLElement The XML node.
     */
    public function toXml(): \SimpleXMLElement
    {
        $result = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><image/>');
        $result->addChild('url', self::encode($this->myUrl->__toString()));
        $result->addChild('title', self::encode($this->myTitle));
        $result->addChild('link', self::encode($this->myLink->__toString()));

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
     * @var UrlInterface My url.
     */
    private $myUrl;

    /**
     * @var string My title.
     */
    private $myTitle;

    /**
     * @var UrlInterface My link.
     */
    private $myLink;
}
