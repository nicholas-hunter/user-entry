<?php
/**
 * Description of db_connection - database connection
 *
 * @author Mattheiu-Rhys Brown
 * @author Shevon Robinson
 */


$user = "jcfuser";
$password = "c0nnectm3n0w@";
$serverName = "192.168.20.5"; 
$connectionInfo = array( "Database"=>"jcfcms", "UID"=>$user, "PWD"=>$password);

$conn = sqlsrv_connect( $serverName, $connectionInfo);


if ($conn) 
{

}
else
{
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