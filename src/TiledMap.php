<?php namespace TiledTmx;

class TiledMap implements ITiledObject
{
    var $version;
    var $orientation;
    var $renderOrder = 'right-down';
    var $width;
    var $height;
    var $tileWidth;
    var $tileHeight;

    /** @var TiledTileSet[] */
    var $tileSets = [];

    /** @var TiledLayer[] */
    var $layers = [];
}
