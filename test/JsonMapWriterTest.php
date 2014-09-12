<?php

class WriterJsonMapTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $tiled = new \TiledTmx\Parser();
        $map = $tiled->parseFile(__DIR__.'/testMap1.tmx');

        $data = \TiledTmx\JsonMapWriter::render($map);
        //file_put_contents('map.json', $data);
    }
}
