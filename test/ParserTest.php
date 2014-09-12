<?php

class ReaderTiledTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $tiled = new \TiledTmx\Parser();
        $map = $tiled->parseFile(__DIR__.'/testMap1.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals(1, count($map->tileSets));
        $this->assertEquals(2, count($map->layers));

        $this->assertEquals(100, $map->width);
        $this->assertEquals(100, $map->height);

        $this->assertEquals(10000, count($map->layers[0]->data));
        $this->assertEquals(10000, count($map->layers[1]->data));
    }
}
