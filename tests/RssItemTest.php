<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Net\Url;
use DateTimeImmutable;
use DateTimeZone;
use MichaelHall\RssFeed\RssItem;
use PHPUnit\Framework\TestCase;

/**
 * Class RssItemTest.
 */
class RssItemTest extends TestCase
{
    /**
     * Test item with standard values.
     */
    public function testItemWithStandardValues()
    {
        $rssItem = new RssItem('The Title', Url::parse('https://example.com/'), 'This is the description.', new DateTimeImmutable('2017-01-02 10:20:30', new DateTimeZone('Europe/Stockholm')));

        self::assertSame('The Title', $rssItem->getTitle());
        self::assertSame('https://example.com/', $rssItem->getLink()->__toString());
        self::assertSame('This is the description.', $rssItem->getDescription());
        self::assertSame('2017-01-02 10:20:30 CET', $rssItem->getPubDate()->format('Y-m-d H:i:s T'));
        self::assertSame('https://example.com/', $rssItem->getGuid());
        self::assertTrue($rssItem->isGuidPermaLink());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/</guid></item>\n", $rssItem->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/</guid></item>\n", $rssItem->__toString());
    }

    /**
     * Test item with permalink GUID.
     */
    public function testItemWithPermalinkGuid()
    {
        $rssItem = new RssItem('The Title', Url::parse('https://example.com/'), 'This is the description.', new DateTimeImmutable('2017-01-02 10:20:30', new DateTimeZone('Europe/Stockholm')));
        $rssItem->setGuid('https://example.com/foo', true);

        self::assertSame('The Title', $rssItem->getTitle());
        self::assertSame('https://example.com/', $rssItem->getLink()->__toString());
        self::assertSame('This is the description.', $rssItem->getDescription());
        self::assertSame('2017-01-02 10:20:30 CET', $rssItem->getPubDate()->format('Y-m-d H:i:s T'));
        self::assertSame('https://example.com/foo', $rssItem->getGuid());
        self::assertTrue($rssItem->isGuidPermaLink());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/foo</guid></item>\n", $rssItem->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/foo</guid></item>\n", $rssItem->__toString());
    }

    /**
     * Test item with non-permalink GUID.
     */
    public function testItemWithNonPermalinkGuid()
    {
        $rssItem = new RssItem('The Title', Url::parse('https://example.com/'), 'This is the description.', new DateTimeImmutable('2017-01-02 10:20:30', new DateTimeZone('Europe/Stockholm')));
        $rssItem->setGuid('FooBar', false);

        self::assertSame('The Title', $rssItem->getTitle());
        self::assertSame('https://example.com/', $rssItem->getLink()->__toString());
        self::assertSame('This is the description.', $rssItem->getDescription());
        self::assertSame('2017-01-02 10:20:30 CET', $rssItem->getPubDate()->format('Y-m-d H:i:s T'));
        self::assertSame('FooBar', $rssItem->getGuid());
        self::assertFalse($rssItem->isGuidPermaLink());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"false\">FooBar</guid></item>\n", $rssItem->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>The Title</title><link>https://example.com/</link><description>This is the description.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"false\">FooBar</guid></item>\n", $rssItem->__toString());
    }

    /**
     * Test encode values.
     */
    public function testEncodeValues()
    {
        $rssItem = new RssItem('Foo & <Bar>', Url::parse('https://example.com/?foo&bar'), 'This is the <description> & Baz.', new DateTimeImmutable('2017-01-02 10:20:30', new DateTimeZone('Europe/Stockholm')));

        self::assertSame('Foo & <Bar>', $rssItem->getTitle());
        self::assertSame('https://example.com/?foo&bar', $rssItem->getLink()->__toString());
        self::assertSame('This is the <description> & Baz.', $rssItem->getDescription());
        self::assertSame('2017-01-02 10:20:30 CET', $rssItem->getPubDate()->format('Y-m-d H:i:s T'));
        self::assertSame('https://example.com/?foo&bar', $rssItem->getGuid());
        self::assertTrue($rssItem->isGuidPermaLink());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>Foo &amp; &lt;Bar&gt;</title><link>https://example.com/?foo&amp;bar</link><description>This is the &lt;description&gt; &amp; Baz.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/?foo&amp;bar</guid></item>\n", $rssItem->toXml()->asXML());
        self::assertSame("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<item><title>Foo &amp; &lt;Bar&gt;</title><link>https://example.com/?foo&amp;bar</link><description>This is the &lt;description&gt; &amp; Baz.</description><pubDate>Mon, 02 Jan 2017 10:20:30 +0100</pubDate><guid isPermaLink=\"true\">https://example.com/?foo&amp;bar</guid></item>\n", $rssItem->__toString());
    }
}
