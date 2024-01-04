<?php
/**
 * Description of db_connection - database connection
 *
 * @author Mattheiu-Rhys Brown
 * @author Shevon Robinson
 */


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'connect';

$dbconnection =  new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($dbconnection -> connect_errno) {
	echo '<h1>Error establishing database connection!!</h1>
        <p>
        It appears that the server encountered an internal error or misconfiguration 
       and was unable to complete the request.
        </p>
        <p>
        Please contact System/Web Administrator or System Development Department.
        </p>';
        exit();
}