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

                $set->images[] = $im;
            }

            // <tileoffset>
            if (isset($tileset->tileoffset)) {
                $set->offsetX = (int) $tileset->tileoffset->attributes()->x;
                $set->offsetY = (int) $tileset->tileoffset->attributes()->y;
            }

            // <terraintypes>
            if (isset($tileset->terraintypes->terrain)) {
                foreach ($tileset->terraintypes->terrain as $currentTerrain) {
                    $terrain = new TiledTerrain;
                    $this->xmlAttributesToObject($currentTerrain, $terrain);
                    $set->terrainTypes[] = $terrain;
                }
            }

            // <tile>
            foreach ($tileset->tile as $currentTile) {
                $tile = new TiledTile;
                $this->xmlAttributesToObject($currentTile, $tile);
                $set->tiles[] = $tile;
            }

            $map->tileSets[] = $set;
        }

        // <layer> + attributes and content
        foreach ($obj->layer as $currentLayer) {

            $layer = new TiledLayer;

            $this->xmlAttributesToObject($currentLayer, $layer);

            // content
            $layer->encoding = (string) $currentLayer->data->attributes()->encoding;
            $layer->compression = (string) $currentLayer->data->attributes()->compression;

            if ($layer->encoding != 'base64' || $layer->compression != 'zlib') {
                throw new \Exception('Unhandled encoding/compression: '.$layer->encoding.', '.$layer->compression);
            }

            $cdata = base64_decode($currentLayer->data);
            $cdata = zlib_decode($cdata);
            $layer->data = array_values(unpack('V*', $cdata));

            $map->layers[] = $layer;
        }

        return $map;
    }

    private function xmlAttributesToObject(\SimpleXMLElement $el, ITiledObject &$obj)
    {
        foreach ($el->attributes() as $name => $val) {
            $name = (string) $name;
            $attrMap = [
                'tilewidth' => 'tileWidth',
                'tileheight' => 'tileHeight',
                'renderorder' => 'renderOrder',
                'firstgid' => 'firstGid',
            ];
            if (array_key_exists($name, $attrMap)) {
                $name = $attrMap[$name];
            }

            $obj->$name = (string) $val;
        }
    }

}
