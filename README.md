Symfony2 Azure Pooc
========================

[![Build Status](https://travis-ci.org/smashou/Symfony2AzurePooc.svg?branch=master)](https://travis-ci.org/smashou/Symfony2AzurePooc)

This Symfony2 project is a really simple WIP POOC for hosting Symfony2 on:
 * Microsoft Azure Websites
 * Azure SQL

And maybe in the future:
* Azure Blob storage
* Azure Mobile notification/push

Feel free ton PR what ever you want :)

Installation
------------

Clone this repository:
```
git clone https://github.com/smashou/Symfony2AzurePooc.git
```

With  [composer](http://packagist.org) :
```
composer install
```

Then run:
```
./install
```

Markdown Bundle
---------------

The [Markdown Bundle](https://github.com/KnpLabs/KnpMarkdownBundle) is provided by [KnpLabs](http://knplabs.com/).

In your config.yml you can customize the markdown parser (Theses options are from [Markdown Bundle](https://github.com/KnpLabs/KnpMarkdownBundle))
```
- markdown.parser.max       // fully compliant = slower (default implementation)
- markdown.parser.medium    // expensive and uncommon features dropped
- markdown.parser.light     // expensive features dropped
- markdown.parser.min       // most features dropped = faster
- markdown.parser.sundown   // faster and fully compliant (recommended)
```

markdown.parser.sundown requires the php [sundown extension](https://github.com/chobie/php-sundown).


TEST
----
Run behat test
```
./bin/behat
```
