<?php

namespace I74ifa\Vaid;

class Apache
{
    public const PATH_APACHE = '/etc/apache2/sites-available/';

    public const SERVER_ADMIN = 'i74ifa@gmail.com';

    public const TLD = '.test';

    public const PORT = '80';

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
<VirtualHost $ip:". self::PORT .">
    DocumentRoot '$basePath'
    ServerName $domain". self::TLD ."
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

    public static function enable($config)
    {
        shell_exec("sudo a2ensite $config");
        shell_exec("sudo systemctl restart apache2");        
    }
    
    public static function disable($config)
    {
        shell_exec("sudo a2dissite $config");
        shell_exec("sudo systemctl restart apache2");
    }
}
