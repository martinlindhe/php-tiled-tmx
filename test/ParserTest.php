<?php

use TiledTmx\Parser;

class ReaderTiledTest extends \PHPUnit_Framework_TestCase
{
    function testOrthogonal()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/desert.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('orthogonal', $map->orientation);

        $this->assertEquals(1, count($map->tileset));
        $this->assertEquals(1, count($map->layer));

        $this->assertEquals(40, $map->width);
        $this->assertEquals(40, $map->height);
        $this->assertEquals(32, $map->tilewidth);
        $this->assertEquals(32, $map->tileheight);

        // test optional casing (magic getter)
        $this->assertEquals(32, $map->tileHeight);
        $this->assertEquals(32, $map->TileHeight);

        $this->assertEquals(1600, count($map->layer[0]->data));
    }

    function testHexagonal()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/hexagonal-mini.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('hexagonal', $map->orientation);
        $this->assertEquals(1, count($map->tileset));
        $this->assertEquals(1, count($map->layer));

        $this->assertEquals(20, $map->width);
        $this->assertEquals(20, $map->height);

        // make sure parser-unaware property is kept
        $this->assertEquals(6, $map->hexSideLength);

        $this->assertEquals(400, count($map->layer[0]->data));

        $this->assertEquals(0, $map->tileset[0]->tileoffset->x);
        $this->assertEquals(1, $map->tileset[0]->tileoffset->y);
    }

    function testIsometric()
    {
        $tiled = new Parser();
        $map = $tiled->parseFile(__DIR__.'/data/isometric_grass_and_water.tmx');

        $this->assertInstanceOf('\TiledTmx\TiledMap', $map);
        $this->assertEquals('isometric', $map->orientation);
        $this->assertEquals(1, count($map->tileset));
        $this->assertEquals(1, count($map->layer));

        $this->assertEquals(25, $map->width);
        $this->assertEquals(25, $map->height);

        $this->assertEquals(625, count($map->layer[0]->data));

        $this->assertEquals(0, $map->tileset[0]->tileoffset->x);
        $this->assertEquals(16, $map->tileset[0]->tileoffset->y);

        $this->assertEquals(2, count($map->tileset[0]->terraintypes));
        $this->assertEquals('Grass', $map->tileset[0]->terraintypes[0]->name);
        $this->assertEquals(0, $map->tileset[0]->terraintypes[0]->tile);

        $this->assertEquals(24, count($map->tileset[0]->tile));

        $this->assertEquals(23, $map->tileset[0]->tile[23]->id);
        $this->assertEquals('1,1,1,1', $map->tileset[0]->tile[23]->terrain);
    }
}
