<?php namespace TiledTmx;

/**
 * <layer> tag
 */
class TiledLayer extends TiledObject
{
    var $name;
    var $width;
    var $height;
    var $encoding;
    var $compression;
    var $properties;

    /** @var string */
    var $data;
}
