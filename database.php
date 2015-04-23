<!--
Title: database.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->

<?php
//Create Database connection, required by all other application files.
class Database
{
    private static $dbName = 'CIS355arschaar';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'CIS355arschaar';
    private static $dbUserPassword = 'arschaar508609';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>