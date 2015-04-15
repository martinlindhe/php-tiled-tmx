<?php

use TiledTmx\Parser;

class ReaderTiledTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/testMap1.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('orthogonal', $map->orientation);
        $this->assertEquals(1, count($map->tileSets));
        $this->assertEquals(2, count($map->layers));

        $this->assertEquals(100, $map->width);
        $this->assertEquals(100, $map->height);

        $this->assertEquals(10000, count($map->layers[0]->data));
        $this->assertEquals(10000, count($map->layers[1]->data));
    }

    function test2()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/hexagonal-mini.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('hexagonal', $map->orientation);
        $this->assertEquals(1, count($map->tileSets));
        $this->assertEquals(1, count($map->layers));

        $this->assertEquals(20, $map->width);
        $this->assertEquals(20, $map->height);

        $this->assertEquals(6, $map->hexsidelength); // make sure parser-unaware property is kept

        $this->assertEquals(400, count($map->layers[0]->data));

        $this->assertEquals(0, $map->tileSets[0]->offsetX);
        $this->assertEquals(1, $map->tileSets[0]->offsetY);
    }

    function test3()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/isometric_grass_and_water.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('isometric', $map->orientation);
        $this->assertEquals(1, count($map->tileSets));
        $this->assertEquals(1, count($map->layers));

        $this->assertEquals(25, $map->width);
        $this->assertEquals(25, $map->height);

        $this->assertEquals(625, count($map->layers[0]->data));

        $this->assertEquals(0, $map->tileSets[0]->offsetX);
        $this->assertEquals(16, $map->tileSets[0]->offsetY);

        $this->assertEquals(2, count($map->tileSets[0]->terrainTypes));
        $this->assertEquals('Grass', $map->tileSets[0]->terrainTypes[0]->name);
        $this->assertEquals(0, $map->tileSets[0]->terrainTypes[0]->tile);

        $this->assertEquals(24, count($map->tileSets[0]->tiles));

        $this->assertEquals(23, $map->tileSets[0]->tiles[23]->id);
        $this->assertEquals('1,1,1,1', $map->tileSets[0]->tiles[23]->terrain);
    }
}
