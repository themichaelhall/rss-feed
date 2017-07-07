<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Url;
use MichaelHall\RssFeed\RssItem;
use PHPUnit\Framework\TestCase;

/**
 * Class RssItemTest.
 */
class RssItemTest extends TestCase
{
    /**
     * Test item with standard values set.
     */
    public function testItemWithStandardValuesSet()
    {
        $rssItem = new RssItem('The Title', Url::parse('https://example.com/'), 'This is the description.', new \DateTimeImmutable('2017-01-02 10:20:30', new \DateTimeZone('Europe/Stockholm')));

        self::assertSame('The Title', $rssItem->getTitle());
        self::assertSame('https://example.com/', $rssItem->getLink()->__toString());
        self::assertSame('This is the description.', $rssItem->getDescription());
        self::assertSame('2017-01-02 10:20:30 CET', $rssItem->getPubDate()->format('Y-m-d H:i:s T'));
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate></item>\n", $rssItem->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate></item>\n", $rssItem->__toString());
    }
}
