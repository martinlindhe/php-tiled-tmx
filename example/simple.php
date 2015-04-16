<?php

require_once __DIR__.'/../vendor/autoload.php';

use TiledTmx\JsonMapWriter as Writer;
use TiledTmx\Parser;

$map = (new Parser)->parseFile('./test/data/testMap1.tmx');
echo Writer::render($map);
