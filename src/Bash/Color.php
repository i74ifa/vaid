<?php

namespace I74ifa\Vaid\Bash;

class Color
{
    protected static $default = "\e[0m";

    public static function red($text)
    {
        return "\e[31m$text" . self::$default;
    }

    public static function green($text)
    {
        return "\e[32m$text" . self::$default;
    }

    public static function yellow($text)
    {
        return "\e[33m$text" . self::$default;
    }

    public static function blue($text)
    {
        return "\e[34m$text" . self::$default;
    }

    public static function magenta($text)
    {
        return "\e[35m$text" . self::$default;
    }

    public static function cyan($text)
    {
        return "\e[36m$text" . self::$default;
    }
}
