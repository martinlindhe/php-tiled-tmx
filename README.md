## About
[![Build Status](https://travis-ci.org/martinlindhe/php-tiled-tmx.png?branch=master)](https://travis-ci.org/martinlindhe/php-tiled-tmx)

Library for reading Tiled .tmx map files,
with a support class for rendering as JSON objects.

Example:

```php
use TiledTmx\JsonMapWriter as Writer;
use TiledTmx\Parser;

$map = (new Parser)->parseFile('./test/data/testMap1.tmx');
echo Writer::render($map);
```


The Tiled Map Editor can be downloaded at http://www.mapeditor.org/


The Tiled TMX format is documented here: https://github.com/bjorn/tiled/wiki/TMX-Map-Format

## Usage

To improve network performance, make sure that your web server has enabled gzip compression for the generated output.

