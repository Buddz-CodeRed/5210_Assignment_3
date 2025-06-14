<?php
    
    //import contents into current script
    include "credentials.php";
    
    // connection to database with credentials.php
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    // get all records from database table
    $record = $connection->prepare("select * from SCP"); // prepares sql query
    $record->execute(); // executes sql query
    $result = $record->get_result(); // returns the results

?>