<?php
namespace App\api;

class DbConfig
{

    const HOST = 'localhost';

    const USER = 'root';

    const PASSWORD = '';

    const DATABASE = 'userprofileapidb';

    public static function getDBConnection()
    {
        try {
            $dbConnection = new \mysqli(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
            
            // if there is an error in database connect process
            if (mysqli_connect_errno()) {
                return false;
            }
            
            return $dbConnection;
        } catch (RuntimeException $e) {
            return false;
        }
    }
}

