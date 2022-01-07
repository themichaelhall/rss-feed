# RSS Feed

[![Tests](https://github.com/themichaelhall/rss-feed/workflows/tests/badge.svg?branch=master)](https://github.com/themichaelhall/rss-feed/actions)
[![StyleCI](https://styleci.io/repos/96578177/shield?style=flat)](https://styleci.io/repos/96578177)
[![License](https://poser.pugx.org/michaelhall/rss-feed/license)](https://packagist.org/packages/michaelhall/rss-feed)
[![Latest Stable Version](https://poser.pugx.org/michaelhall/rss-feed/v/stable)](https://packagist.org/packages/michaelhall/rss-feed)
[![Total Downloads](https://poser.pugx.org/michaelhall/rss-feed/downloads)](https://packagist.org/packages/michaelhall/rss-feed)

Simple RSS feed creator.

## Requirements

- PHP >= 7.3

## Install with composer

``` bash
$ composer require michaelhall/rss-feed
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use DataTypes\Net\Url;
use MichaelHall\RssFeed\RssFeed;
use MichaelHall\RssFeed\RssItem;

// Create the feed.
$feed = new RssFeed(
    'Feed Title',
    Url::parse('https://example.com/'),
    'The feed description.'
);

// This is optional but recommended by W3C feed validator.
$feed->setFeedUrl(Url::parse('https://example.com/path/to/feed'));

// Add an item.
$feedItem = new RssItem(
    'Item Title',
    Url::parse('https://example.com/path/to/item-page'),
    'The item description',
    new DateTimeImmutable('2017-08-22 19:56:00')
);

$feed->addItem($feedItem);

// Prints the RSS feed.
echo $feed;
```

### Add an image to the feed

```php
use MichaelHall\RssFeed\RssImage;

$feedImage = new RssImage(
    Url::parse('https://example.com/path/to/image'),
    'Image Title',
    Url::parse('https://example.com/')
);

$feed->setImage($feedImage);
```

## License

MIT
