<?php

// //Connection to the database that will facilitate the audit and management of the information entered, update and archived by the Operations Staff
// include("includes/db_connection.php");
// //Connection to the pms database that will facilitate the search of the personnel table for the specfic officer
// include("includes/pms_connection.php");

function fetchData($regulationNumber, $conn) 
{
    $sql = "SELECT * FROM srsmPersonnel WHERE regulationNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regulationNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return $row;
}


function insertData($dbconnection, $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber)
{
    echo  "Insert Data".$fName.$forenameTwo.$surname.$rankname.$emailAddress.$gender.$entryDate.$regulationNumber;
    $sql = "INSERT INTO srsmPersonnel (fName, forenameTwo, surname, rankname, emailAddress, gender, entryDate, regulationNumber)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($sql);
    $stmt->bind_param("ssssssss", $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber);

    return $stmt->execute();
}

?>

