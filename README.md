# RSS Feed

[![Build Status](https://travis-ci.org/themichaelhall/rss-feed.svg?branch=master)](https://travis-ci.org/themichaelhall/rss-feed)
[![codecov.io](https://codecov.io/gh/themichaelhall/rss-feed/coverage.svg?branch=master)](https://codecov.io/gh/themichaelhall/rss-feed?branch=master)
[![Code Climate](https://codeclimate.com/github/themichaelhall/rss-feed/badges/gpa.svg)](https://codeclimate.com/github/themichaelhall/rss-feed)
[![StyleCI](https://styleci.io/repos/96578177/shield?style=flat)](https://styleci.io/repos/96578177)
[![License](https://poser.pugx.org/michaelhall/rss-feed/license)](https://packagist.org/packages/michaelhall/rss-feed)
[![Latest Stable Version](https://poser.pugx.org/michaelhall/rss-feed/v/stable)](https://packagist.org/packages/michaelhall/rss-feed)
[![Total Downloads](https://poser.pugx.org/michaelhall/rss-feed/downloads)](https://packagist.org/packages/michaelhall/rss-feed)

Simple RSS feed creator.

## Requirements

- PHP >= 7.1

## Install with composer

``` bash
$ composer require "michaelhall/rss-feed:~1.0"
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// Create the feed.
$feed = new \MichaelHall\RssFeed\RssFeed(
    'Feed Title', 
    \DataTypes\Url::parse('https://example.com/'),
    'The feed description.'
);

// This is optional but recommended by W3C feed validator.
$feed->setFeedUrl(\DataTypes\Url::parse('https://example.com/path/to/feed'));

// Add an item.
$feedItem = new \MichaelHall\RssFeed\RssItem(
   'Item Title',
   \DataTypes\Url::parse('https://example.com/path/to/item-page'),
   'The item description',
   new \DateTimeImmutable('2017-08-22 19:56:00')
);

$feed->addItem($feedItem);

// Prints the RSS feed.
echo $feed;
```

## License

MIT