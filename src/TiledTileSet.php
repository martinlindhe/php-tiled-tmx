<?php namespace TiledTmx;

class TiledTileSet implements ITiledObject
{
    var $firstGid;
    var $name;
    var $tileWidth;
    var $tileHeight;

    // corresponds to <tileoffset> tag inside a <tileset>
    var $offsetX = 0;
    var $offsetY = 0;

    /** @var TiledImage[] */
    var $images = [];

    /** @var TiledTerrain[] */
    var $terrainTypes = [];

    /** @var TiledTile[] */
    var $tiles = [];
}
