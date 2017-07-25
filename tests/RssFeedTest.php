<?php

declare(strict_types=1);

namespace MichaelHall\RssFeed\Tests;

use DataTypes\Url;
use MichaelHall\RssFeed\RssFeed;
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
}
