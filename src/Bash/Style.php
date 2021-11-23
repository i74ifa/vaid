<?php

namespace I74ifa\Vaid\Bash;

use I74ifa\Laravel\System;
use I74ifa\Laravel\SysUsing;

class Style
{
    protected const WHITESPACE = 20;

    protected static $space;

    public static function whiteSpace($key, $value)
    {
        $len = strlen($key);
        $len = self::WHITESPACE - $len;
        self::makeSpace($len);
        return self::Color($key, 'green') . self::$space . "$value\n";
    }

    protected static function makeSpace($len)
    {
        $whitespace = '';
        for ($i =0; $i < $len; $i++):
            $whitespace .= " ";
        endfor;
        self::$space = $whitespace;
    }
    /**
     * get Color by using
     * 
     */
    public static function Color($value, $nameColor)
    {
        return Color::$nameColor($value);
    }
}
