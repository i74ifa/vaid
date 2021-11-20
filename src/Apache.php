<?php

namespace I74ifa\Vhost;

class Apache
{
    public const PATH_APACHE = '/etc/apache2/sites-available/';

    public const SERVER_ADMIN = 'i74ifa@gmail.com';

    public static function projectExist($domain)
    {

        foreach (scandir(self::PATH_APACHE) as $file) {
            if (strpos($file, $domain) !== false) {
                return true;
            }
        }
        return false;
    }


    public static function contentFile($ip, $basePath, $domain)
    {
        return "
<VirtualHost $ip:82>
    DocumentRoot '$basePath'
    ServerName $domain.test
    ServerAdmin " . self::SERVER_ADMIN . "
    <Directory '$basePath'>
        Options All
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>";
    }

    public static function generateIp()
    {
        $ip = "127.0.";


        $ip .= random_int(1, 255);


        $ip .= '.' . random_int(1, 255);
        return $ip;
    }
}
