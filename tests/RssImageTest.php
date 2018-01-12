<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Url;
use MichaelHall\RssFeed\RssImage;
use PHPUnit\Framework\TestCase;

/**
 * Class RssImageTest.
 */
class RssImageTest extends TestCase
{
    /**
     * Test image with standard values.
     */
    public function testImageWithStandardValues()
    {
        $rssImage = new RssImage(Url::parse('https://example.com/image.jpg'), 'The Image Title', Url::parse('https://example.com/'));

        self::assertSame('https://example.com/image.jpg', $rssImage->getUrl()->__toString());
        self::assertSame('The Image Title', $rssImage->getTitle());
        self::assertSame('https://example.com/', $rssImage->getLink()->__toString());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<image><url>https://example.com/image.jpg</url><title>The Image Title</title><link>https://example.com/</link></image>\n", $rssImage->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<image><url>https://example.com/image.jpg</url><title>The Image Title</title><link>https://example.com/</link></image>\n", $rssImage->__toString());
    }

    /**
     * Test encode values.
     */
    public function testEncodeValues()
    {
        $rssImage = new RssImage(Url::parse('https://example.com/image.jpg'), 'The <h1>Image</h1> & Title', Url::parse('https://example.com/'));

        self::assertSame('https://example.com/image.jpg', $rssImage->getUrl()->__toString());
        self::assertSame('The <h1>Image</h1> & Title', $rssImage->getTitle());
        self::assertSame('https://example.com/', $rssImage->getLink()->__toString());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<image><url>https://example.com/image.jpg</url><title>The &lt;h1&gt;Image&lt;/h1&gt; &amp; Title</title><link>https://example.com/</link></image>\n", $rssImage->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<image><url>https://example.com/image.jpg</url><title>The &lt;h1&gt;Image&lt;/h1&gt; &amp; Title</title><link>https://example.com/</link></image>\n", $rssImage->__toString());
    }
}
