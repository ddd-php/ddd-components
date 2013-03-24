<?php

namespace Ddd\Slug\Tests;

class AcceptanceDataProvider
{
    public static function getEntityAsciiTextSlugificationData()
    {
        return array(
            array('    ',             ''),
            array('&&&é---',          'e'),
            array('hello world !!',   'hello-world'),
            array('hello      world', 'hello-world'),
            array('AbC',              'abc'),
            array('é&tè!hello_(_',    'e-te-hello'),
        );
    }

    public static function getEntityLatinTransliteratedSlugificationData()
    {
        return array(
            array('hello',    'hello'),
            array('étrange',  'etrange'),
            array('habitó',   'habito'),
            array('straße',   'strasse'),
            array('señorita-holla', 'senorita-holla'),
        );
    }
}
