<?php

namespace I74ifa\Vaid;

class Host
{
    public const PATH_HOSTS = '/etc/hosts';
    public static function add($ip, $alias)
    {

        $content = "$ip    $alias". Apache::TLD;

        $content .= "\n" . file_get_contents(self::PATH_HOSTS);

        file_put_contents(self::PATH_HOSTS, $content);
        return true;
    }

    public static function remove($alias)
    {
        $file = file_get_contents(self::PATH_HOSTS);
        $content = explode(PHP_EOL, trim($file));
        $field = '';
        foreach ($content as $line) {
            if (strpos($line, $alias) !== false){
                $field = $line;
            }
        }

        $content = trim(str_replace($field, '', $file));

        file_put_contents(self::PATH_HOSTS, $content);

        return true;
    }
}
