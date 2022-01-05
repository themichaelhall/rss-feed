<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Url;
use DateTimeImmutable;
use DateTimeZone;
use MichaelHall\RssFeed\RssFeed;
use MichaelHall\RssFeed\RssImage;
use MichaelHall\RssFeed\RssItem;
use PHPUnit\Framework\TestCase;

/**
 * Class RssFeedTest.
 */
class RssFeedTest extends TestCase
{
    /**
     * Test empty feed with standard values set.
     */
    public function testEmptyFeedWithStandardValuesSet()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
        self::assertNull($rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test a feed with items.
     */
    public function testFeedWithItems()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');
        $rssFeed->addItem(new RssItem('First Item', Url::parse('https://example.com/item_1'), 'This is the first item.', new DateTimeImmutable('2017-07-26 18:30:00', new DateTimeZone('Europe/Stockholm'))));
        $rssFeed->addItem(new RssItem('Second Item', Url::parse('https://example.com/item_2'), 'This is the second item.', new DateTimeImmutable('2017-07-26 20:30:00', new DateTimeZone('Europe/Stockholm'))));

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
        self::assertNull($rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><item><title>First Item</title><link>https://example.com/item_1</link><description>This is the first item.</description><pubDate>Wed, 26 Jul 2017 18:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_1</guid></item><item><title>Second Item</title><link>https://example.com/item_2</link><description>This is the second item.</description><pubDate>Wed, 26 Jul 2017 20:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_2</guid></item></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><item><title>First Item</title><link>https://example.com/item_1</link><description>This is the first item.</description><pubDate>Wed, 26 Jul 2017 18:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_1</guid></item><item><title>Second Item</title><link>https://example.com/item_2</link><description>This is the second item.</description><pubDate>Wed, 26 Jul 2017 20:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_2</guid></item></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test feed with feed url.
     */
    public function testEmptyFeedWithFeedUrl()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');
        $rssFeed->setFeedUrl(Url::parse('https://example.com/rss'));

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
        self::assertNull($rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><atom:link href=\"https://example.com/rss\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><atom:link href=\"https://example.com/rss\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test encode values.
     */
    public function testEncodeValues()
    {
        $rssFeed = new RssFeed('Foo & Bar', Url::parse('https://example.com/?foo&bar'), 'This is the <description> & Baz.');
        $rssFeed->setFeedUrl(Url::parse('https://example.com/rss?foo&bar'));

        self::assertSame('Foo & Bar', $rssFeed->getTitle());
        self::assertSame('https://example.com/?foo&bar', $rssFeed->getLink()->__toString());
        self::assertSame('This is the <description> & Baz.', $rssFeed->getDescription());
        self::assertNull($rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>Foo &amp; Bar</title><link>https://example.com/?foo&amp;bar</link><description>This is the &lt;description&gt; &amp; Baz.</description><atom:link href=\"https://example.com/rss?foo&amp;amp;bar\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>Foo &amp; Bar</title><link>https://example.com/?foo&amp;bar</link><description>This is the &lt;description&gt; &amp; Baz.</description><atom:link href=\"https://example.com/rss?foo&amp;amp;bar\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test empty feed with image.
     */
    public function testEmptyFeedWithImage()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');
        $rssImage = new RssImage(Url::parse('https://expamle.com/image.jpg'), 'The image', Url::parse('https://example.com/start'));
        $rssFeed->setImage($rssImage);

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
        self::assertSame($rssImage, $rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><image><url>https://expamle.com/image.jpg</url><title>The image</title><link>https://example.com/start</link></image></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><image><url>https://expamle.com/image.jpg</url><title>The image</title><link>https://example.com/start</link></image></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test a feed with image and items.
     */
    public function testFeedWithImageAndItems()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');
        $rssFeed->addItem(new RssItem('First Item', Url::parse('https://example.com/item_1'), 'This is the first item.', new DateTimeImmutable('2017-07-26 18:30:00', new DateTimeZone('Europe/Stockholm'))));
        $rssFeed->addItem(new RssItem('Second Item', Url::parse('https://example.com/item_2'), 'This is the second item.', new DateTimeImmutable('2017-07-26 20:30:00', new DateTimeZone('Europe/Stockholm'))));

        $rssImage = new RssImage(Url::parse('https://expamle.com/image.jpg'), 'The image', Url::parse('https://example.com/start'));
        $rssFeed->setImage($rssImage);

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
        self::assertSame($rssImage, $rssFeed->getImage());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><image><url>https://expamle.com/image.jpg</url><title>The image</title><link>https://example.com/start</link></image><item><title>First Item</title><link>https://example.com/item_1</link><description>This is the first item.</description><pubDate>Wed, 26 Jul 2017 18:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_1</guid></item><item><title>Second Item</title><link>https://example.com/item_2</link><description>This is the second item.</description><pubDate>Wed, 26 Jul 2017 20:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_2</guid></item></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><image><url>https://expamle.com/image.jpg</url><title>The image</title><link>https://example.com/start</link></image><item><title>First Item</title><link>https://example.com/item_1</link><description>This is the first item.</description><pubDate>Wed, 26 Jul 2017 18:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_1</guid></item><item><title>Second Item</title><link>https://example.com/item_2</link><description>This is the second item.</description><pubDate>Wed, 26 Jul 2017 20:30:00 +0200</pubDate><guid isPermaLink=\"true\">https://example.com/item_2</guid></item></channel></rss>\n", $rssFeed->__toString());
    }
}
