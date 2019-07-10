<?php namespace TiledTmx;

/**
 * Parses Tiled .xml maps
 */
class Parser
{
    /**
     * @param string $fileName
     * @return TiledMap
     */
    public function parseFile($fileName)
    {
        return $this->parseData(file_get_contents($fileName));
    }

    /**
     * @param string $data
     * @return TiledMap
     * @throws \Exception
     */
    public function parseData($data)
    {
        $obj = new \SimpleXMLElement($data);

        // <map> attributes
        $map = new TiledMap;
        $this->xmlAttributesToObject($obj, $map);

        // <tileset> + attributes and content
        foreach ($obj->tileset as $tileset) {

            $set = new TiledTileSet;
            $this->xmlAttributesToObject($tileset, $set);

            // <image>
            foreach ($tileset->image as $image) {

                $im = new TiledImage;
                $this->xmlAttributesToObject($image, $im);

                $set->image[] = $im;
            }

            // <tileoffset>
            if (isset($tileset->tileoffset)) {
                $tileoffset = new TiledTileOffset;
                $tileoffset->x = (int) $tileset->tileoffset->attributes()->x;
                $tileoffset->y = (int) $tileset->tileoffset->attributes()->y;
                $set->tileoffset = $tileoffset;
            }

            // <terraintypes>
            if (isset($tileset->terraintypes->terrain)) {
                foreach ($tileset->terraintypes->terrain as $currentTerrain) {
                    $terrain = new TiledTerrain;
                    $this->xmlAttributesToObject($currentTerrain, $terrain);
                    $set->terraintypes[] = $terrain;
                }
            }

            // <tile>
            foreach ($tileset->tile as $currentTile) {
                $tile = new TiledTile;
                $this->xmlAttributesToObject($currentTile, $tile);
                $set->tile[] = $tile;
            }

            $map->tileset[] = $set;
        }

        // <layer> + attributes and content
        foreach ($obj->layer as $currentLayer) {

            $layer = new TiledLayer;

            $this->xmlAttributesToObject($currentLayer, $layer);

            // content
            $layer->encoding = (string) $currentLayer->data->attributes()->encoding;
            $layer->compression = (string) $currentLayer->data->attributes()->compression;

            if ($currentLayer->properties && $currentLayer->properties->property) {
                foreach ($currentLayer->properties->property as $property) {
                    $layer->properties[(string)$property->attributes()->name] = (string)$property->attributes()->value;
                }
            }

            if ($layer->encoding != 'base64' || $layer->compression != 'zlib') {
                throw new \Exception('Unhandled encoding/compression: '.$layer->encoding.', '.$layer->compression);
            }

            $cdata = base64_decode($currentLayer->data);
            $cdata = zlib_decode($cdata);
            $layer->data = array_values(unpack('V*', $cdata));

            $map->layer[] = $layer;
        }

        return $map;
    }

    private function xmlAttributesToObject(\SimpleXMLElement $el, TiledObject &$obj)
    {
        foreach ($el->attributes() as $name => $val) {
            $name = (string) $name;
            $obj->$name = (string) $val;
        }
    }

}
