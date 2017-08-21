<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Url;
use MichaelHall\RssFeed\RssFeed;
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
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description></channel></rss>\n", $rssFeed->__toString());
    }

    /**
     * Test a feed with items.
     */
    public function testFeedWithItems()
    {
        $rssFeed = new RssFeed('The Title', Url::parse('https://example.com/'), 'This is the description.');
        $rssFeed->addItem(new RssItem('First Item', Url::parse('https://example.com/item_1'), 'This is the first item.', new \DateTimeImmutable('2017-07-26 18:30:00', new \DateTimeZone('Europe/Stockholm'))));
        $rssFeed->addItem(new RssItem('Second Item', Url::parse('https://example.com/item_2'), 'This is the second item.', new \DateTimeImmutable('2017-07-26 20:30:00', new \DateTimeZone('Europe/Stockholm'))));

        self::assertSame('The Title', $rssFeed->getTitle());
        self::assertSame('https://example.com/', $rssFeed->getLink()->__toString());
        self::assertSame('This is the description.', $rssFeed->getDescription());
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
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><atom:link href=\"https://example.com/rss\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><atom:link href=\"https://example.com/rss\" rel=\"self\" type=\"application/rss+xml\"/></channel></rss>\n", $rssFeed->__toString());
    }
}
