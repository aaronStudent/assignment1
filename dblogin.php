<?php

   // Database login details
   $hostname = 'localhost';
   $username = 'webadmin';
   $password = 'password';

   // Attempt connection
   try 
   {
      $dbconn = new PDO("mysql:host=$hostname;dbname=winestore", $username, $password);
   }
   catch(PDOException $e)
   {
      echo $e->getMessage();
   }

?>