## About


[![Build Status](https://travis-ci.org/martinlindhe/php-tiled-tmx.png?branch=master)](https://travis-ci.org/martinlindhe/php-tiled-tmx)

Library for reading Tiled .tmx map files,
with a support class for rendering as JSON objects.

Example:

```php
$tiled = new \TiledTmx\Parser();
$map = $tiled->parseFile('/map.tmx');

echo \TiledTmx\JsonMapWriter::render($map);
```


The Tiled Map Editor can be downloaded at http://www.mapeditor.org/
