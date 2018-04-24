<?php
/*--------------------BEGINNING OF THE CONNECTION PROCESS------------------*/
//define constants for db_host, db_user, db_pass, and db_database
//adjust the values below to match your database settings

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); //make sure the user is correct
define('DB_PASS', 'root'); //make sure it is the right password
define('DB_DATABASE', 'mydb'); //we will use this database
//connect to database host. The mysqli_connect() function opens a new connection to the MySQL server and returns an object representing the connection to the MySQL server
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

//make sure connection is good or die
// The mysqli_connect_errno() function returns the error code from the last connection error, if any.
// The mysqli_connect_error() function returns the error description from the last connection error, if any. It returns a string that describes the error.
// The PHP die function prints a message (required) and exits the current script
if ($connection->connect_errno) {
    die("Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error);
}
/*-----------------------END OF CONNECTION PROCESS------------------------*/

/*----------------------DATABASE QUERYING FUNCTIONS-----------------------*/
/*----------------------DONT TOUCH THESE FUNCTIONS------------------------*/
/*-----------------------THESE ARE FOR USAGE ONLY------------------------*/
//SELECT - used when expecting single OR multiple results
//returns an array that contains one or more associative arrays
function fetch_all($query) {
    $data = array();
    global $connection;
    // query performs a query against the database. For successful SELECT queries it will return a mysqli_result object.
    $result = $connection->query($query);

    // The mysqli_fetch_assoc() function fetches a result row as an associative array. It returns an associative array of strings representing the fetched row.
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}
//SELECT - used when expecting a single result
//returns an associative array
function fetch_record($query) {
    global $connection;
    $result = $connection->query($query);

    return mysqli_fetch_assoc($result);
}
//used to run INSERT/DELETE/UPDATE, queries that don't return a value
//returns a value, the id of the most recently inserted record in your database
function run_mysql_query($query) {
    global $connection;
    $result = $connection->query($query);

    return $connection->insert_id;
}
//returns an escaped string. EG, the string "That's crazy!" will be returned as "That\'s crazy!"
//also helps secure your database against SQL injection
function escape_this_string($string) {
    global $connection;

    return $connection->real_escape_string($string);
}
/*----------------------END OF DATABASE QUERYING FUNCTIONS-----------------------*/

?>
