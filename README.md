```
                                       SIMPLON FEED
                                        
                                                   __.----.___
                       ||            ||  (\(__)/)-'||      ;--` ||
                      _||____________||___`(QQ)'___||______;____||_
                      -||------------||----)  (----||-----------||-
                      _||____________||___(o  o)___||______;____||_
                      -||------------||----`--'----||-----------||-
                       ||            ||       `|| ||| || ||     ||
                    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
```
## Intro

When I was searching for an RSS feed reader I did not find any which was able to pass along ```namespaced``` data. So I wrote one which
parses all possible fields, combined with ```namespace fields``` and possible ```custom fields```.  Since its hard to stand on one leg I also
added a parser for the ```ATOM``` format. Same story here only a couple of variations when it comes to the feed tag names.

I've spent some time on parsing all tags including possible attributes. However, if you run in to any issues let me know.

## 1. Install

Easy install via composer. Still no idea what composer is? Inform yourself [here](http://getcomposer.org).

```json
{
  "require": {
    "simplon/feed": "*"
  }
}
```
 
## 2. Usage

Following you can find two examples for fetching, parsing and reading feeds. Note that both examples require composer to be ```required``` beforehand.
 
### RSS  2.0
```php
use Simplon\Feed\FeedReader;

$feed = new FeedReader();

// lets fetch all feed details and its items
$feedVo = $feed->rss('http://feeds.feedburner.com/techcrunch/europe?format=xml');

// e.g. reading title
var_dump($feedVo->getTitle());

// access possible namespaces
var_dump($feedVo->getNamespaces());

// access possible meta data
var_dump($feedVo->getMetas());

// access all items
foreach($feedVo->getItems() as $item)
{
    // e.g. reading title
    var_dump($item->getTitle());
    
    // access possible namespaces
    var_dump($item->getNamespaces());
    
    // access possible meta data
    var_dump($item->getMetas());
}
```

### ATOM 1.0

```php
use Simplon\Feed\FeedReader;

$feed = new FeedReader();

// lets fetch all feed details and its items
$feedVo = $feed->atom('http://vvv.tobiassjosten.net/feed.atom');

// e.g. reading title
var_dump($feedVo->getTitle());

// access possible namespaces
var_dump($feedVo->getNamespaces());

// access possible meta data
var_dump($feedVo->getMetas());

// access all items
foreach($feedVo->getItems() as $item)
{
    // e.g. reading title
    var_dump($item->getTitle());
    
    // access possible namespaces
    var_dump($item->getNamespaces());
    
    // access possible meta data
    var_dump($item->getMetas());
}
```

-------------------------------------------------

# License
Simplon freed is freely distributable under the terms of the MIT license.

Copyright (c) 2015 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.