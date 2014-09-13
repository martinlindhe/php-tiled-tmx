<?php

class WriterJsonMapTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $tiled = new \TiledTmx\Parser();
        $map = $tiled->parseFile(__DIR__.'/testMap1.tmx');

        $this->assertEquals(
            '{'.
                '"width":"100",'.
                '"height":"100",'.
                '"tileWidth":"16",'.
                '"tileHeight":"16",'.
                '"layers":['.
                    '{'.
                        '"name":"Tile Layer 1",'.
                        '"width":"100",'.
                        '"height":"100",'.
                        '"data":"eJzt1lFuwyAMgOEL+QGHBMNZpt3\/GjO0mxLWSeSJUf364spJ+mAXnPQjCABgLotiu9ghlsSs5T+n+\/VWnl7sOA2HR7kfOrvyW11GE911PGqHLd+m136zS9+nl3i1dud7Ld+n136zy76jv9Zw3R1b5\/K8E993LusOvMxcv47Jw06RV5vLdJq72tGr2YxZskn2z\/ozhHcYyn5BvUVVv7b59zd9dLnWdh15WdYuD+\/u2Dziil2OviztHHHFoexflkOx0lzGXeLRjiS+rM+kO\/UkSyzTix2XkiRrRxZfx2fSnRYx\/9uu04sdV7KUUg8N9WGj3+nvKzXV4E+YEKdXDQAAAAAAAAAAAAAAAAAAAAAAAAAAAAD\/zOcXGIBdkw=="'.
                    '},'.
                    '{'.
                        '"name":"obj-tiles",'.
                        '"width":"100",'.
                        '"height":"100",'.
                        '"data":"eJztz7ENwzAMRcGFWFhyqFizBNl\/jXACI4AKFT4cf\/\/4OQL4V16RM8YRo21vWTXrWswe89zesqr1Xjtrr1pu71n+J+uPzNqovbf3cK9d1\/aGp38AAAAAAAAAAAAAAAAAAAAAAPAQ3x+uNxEb"'.
                    '}'.
                '],'.
                '"tileSets":['.
                    '{'.
                        '"name":"floating_islands",'.
                        '"tileWidth":"16",'.
                        '"tileHeight":"16",'.
                        '"images":['.
                            '{'.
                                '"source":"..\/img\/floating_islands.png",'.
                                '"width":"512",'.
                                '"height":"512"'.
                            '}'.
                        ']'.
                    '}'.
                ']'.
            '}',
            \TiledTmx\JsonMapWriter::render($map)
        );
    }
}
