<?php 
    class Db {
            
            private static $conn;

            public static function getConnection() {
                include_once(__DIR__ . "/../settings/settings.php");
            
                if(self::$conn === null) {
                    try {
                        self::$conn = new PDO('mysql:host=' . SETTINGS['db']['host'] . ';port=' . SETTINGS['db']['port'] . ';dbname=' . SETTINGS['db']['dbname'], SETTINGS['db']['user'], SETTINGS['db']['password']);
                    }catch(PDOException $th) {
                       $eror = $th->getMessage();
                    }
                    

                    return self::$conn;
                }else {
                    return self::$conn;
                }
                
            }  
        }