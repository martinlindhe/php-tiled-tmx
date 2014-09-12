<?php
namespace TiledTmx;

/**
 * Parses Tiled .xml maps
 */
class Parser
{
    private $parser;
    private $map;

    private $currentTag = null;
    private $currentTileset = null;
    private $currentLayer = null;

    public function __construct()
    {
        $this->parser = xml_parser_create();
        $this->map = new TiledMap();

        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'tagOpen', 'tagClose');
        xml_set_character_data_handler($this->parser, 'cdata');
    }

    /**
     * @return TiledMap
     */
    public function parseFile($fileName)
    {
        if (!file_exists($fileName)) {
            throw new \Exception('file not found: '.$fileName);
        }

        return $this->parseData(file_get_contents($fileName));
    }

    /**
     * @return TiledMap
     */
    public function parseData($data)
    {
        xml_parse($this->parser, $data);
        return $this->map;
    }

    private function tagOpen($parser, $tag, $attributes)
    {
        $this->currentTag = $tag;

        if ($tag == 'MAP') {
            $this->map->version = $attributes['VERSION'];
            $this->map->orientation = $attributes['ORIENTATION'];
            $this->map->width = $attributes['WIDTH'];
            $this->map->height = $attributes['HEIGHT'];
            $this->map->tileWidth = $attributes['TILEWIDTH'];
            $this->map->tileHeight = $attributes['TILEHEIGHT'];
        } else if ($tag == 'TILESET') {
            $set = new TiledTileSet();
            $set->firstGid = $attributes['FIRSTGID'];
            $set->name = $attributes['NAME'];
            $set->tileWidth = $attributes['TILEWIDTH'];
            $set->tileHeight = $attributes['TILEHEIGHT'];
            $this->currentTileset = $set;
        } else if ($tag == 'IMAGE') {
            // NOTE assumes inside TILESET tag
            $img = new TiledImage();
            $img->source = $attributes['SOURCE'];
            $img->width = $attributes['WIDTH'];
            $img->height = $attributes['HEIGHT'];
            $this->currentTileset->images[] = $img;
        } else if ($tag == 'LAYER') {
            $layer = new TiledLayer();
            $layer->name = $attributes['NAME'];
            $layer->width = $attributes['WIDTH'];
            $layer->height = $attributes['HEIGHT'];
            $this->currentLayer = $layer;
        } else if ($tag == 'DATA') {
            $this->currentLayer->encoding = $attributes['ENCODING'];
            $this->currentLayer->compression = $attributes['COMPRESSION'];
        } else {
            var_dump($parser, $tag, $attributes);
            throw new \Exception('unrecognized tag: '.$tag);
        }
    }

    private function tagClose($parser, $tag)
    {
        $this->currentTag = null;
        if ($tag == 'TILESET') {
            $this->map->tileSets[] = $this->currentTileset;
            $this->currentTileset = null;
        } else if ($tag == 'LAYER') {
            $this->map->layers[] = $this->currentLayer;
            $this->currentLayer = null;
        }
    }

    private function cdata($parser, $cdata)
    {
        if ($this->currentTag == 'DATA') {
            if ($this->currentLayer->encoding == 'base64') {
                $cdata = base64_decode($cdata);
            } else {
                throw new \Exception('unhandled layer encoding: '.$this->currentLayer->encoding);
            }

            if ($this->currentLayer->compression == 'zlib') {
                $cdata = zlib_decode($cdata);
            } else {
                throw new \Exception('unhandled layer compression: '.$this->currentLayer->compression);
            }

            $this->currentLayer->data = array_values(unpack('V*', $cdata));
        }
    }
}
