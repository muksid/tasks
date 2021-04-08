<?php

/**
 *
 */
class Database
{

    function __construct()
    {

        try {

            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASSWORD);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $err) {

            die($err->getMessage());

        }
    }
}

define('DB_HOST', 'localhost');

define('DB_NAME', 'tasks');

define('DB_CHARSET', 'utf8');

define('DB_USER', 'root');

define('DB_PASSWORD', '');
