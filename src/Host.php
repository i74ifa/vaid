<?php

namespace I74ifa\Vhost;

class Host
{
    public const PATH_HOSTS = '/etc/hosts';
    public static function add($ip, $alias)
    {

        $content = "$ip    $alias";

        $content .= "\n" . file_get_contents(self::PATH_HOSTS);

        file_put_contents(self::PATH_HOSTS, $content);
        return true;
    }
}
