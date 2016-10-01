<?php
return (function(){
    $hostname = 'msenterprise.waltoncollege.uark.edu';
    $database = 'ISYS4283306';
    $username = 'ISYS4283306';
    $password = 'UM07bu$';
    // https://www.microsoft.com/en-us/download/details.aspx?id=50419
    $driver   = 'ODBC Driver 13 for SQL Server';

    $pdo = new PDO("odbc:Driver=$driver;
        Server=$hostname;
        Database=$database",
        $username,
        $password
    );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    return $pdo;
})();
