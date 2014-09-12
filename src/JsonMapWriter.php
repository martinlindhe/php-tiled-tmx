<?php
namespace TiledTmx;

/**
 * Writes a compact JSON object representing a Tiled map
 * Data points are encoded using base64 + zlib
 */
class JsonMapWriter
{
    public static function render(TiledMap $map)
    {
        $layers = array();
        foreach ($map->layers as $layer) {
            $layers[] = array(
                'name' => $layer->name,
                'width' => $layer->width,
                'height' => $layer->height,
                'data' => base64_encode(zlib_encode(json_encode($layer->data), ZLIB_ENCODING_DEFLATE))
            );
        }

        $tileSets = array();
        foreach ($map->tileSets as $tileSet) {
            $set = array(
                'name' => $tileSet->name,
                'tileWidth' => $tileSet->tileWidth,
                'tileHeight' => $tileSet->tileHeight
            );
            foreach ($tileSet->images as $image) {
                $set['images'][] = array(
                    'source' => $image->source,
                    'width' => $image->width,
                    'height' => $image->height
                );
            }
            $tileSets[] = $set;
        }

        $arr = array(
            'width' => $map->width,
            'height' => $map->height,
            'tileWidth' => $map->tileWidth,
            'tileHeight' => $map->tileHeight,
            'layers' => $layers,
            'tileSets' => $tileSets
        );

        return json_encode($arr);
    }
}
