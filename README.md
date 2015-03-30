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

Still in the process of wrapping everything up. There are only a couple of hick-ups in parsing
attributes from multi-tag occurences. Anyway, I am on it but most of the feeds should be parsed correctly.
 
### Usage RSS  
```php
$feed = new FeedReader();

// lets fetch all feed details and its items
$feedVo = $feed->rss('http://www.spiegel.de/schlagzeilen/tops/index.rss');

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
 
### Usage ATOM

In the process. Have a look at ```/test/test.php```
    
-------------------------------------------------

# License
Simplon freed is freely distributable under the terms of the MIT license.

Copyright (c) 2015 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.