<?php namespace TiledTmx;

/**
 * <map> tag
 */
class TiledMap extends TiledObject
{
    var $version;
    var $orientation;
    var $renderorder = 'right-down';
    var $width;
    var $height;
    var $tilewidth;
    var $tileheight;

    /** @var TiledTileSet[] */
    var $tileset = [];

    /** @var TiledLayer[] */
    var $layer = [];
}
