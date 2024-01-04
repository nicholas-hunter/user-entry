<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles2.css">
    <title>SRMS Entry Form</title>
</head>
<body>
<?php
    include("includes/db_connection.php");
    include("functions/entry_functions.php");




// Initialize variables
$fName = $forenameTwo = $surname = $rankname = $emailAddress = $gender = $entryDate = $regulationNumber = $recordStatus = "";

    // Handle form submission for new records
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Submit"])) {
        $fName = $_POST["fName"] ?? "";
        $forenameTwo = $_POST["forenameTwo"] ?? "";
        $surname = $_POST["surname"] ?? "";
        $rankname = $_POST["rankname"] ?? "";
        $emailAddress = $_POST["emailAddress"] ?? "";
        $gender = $_POST["gender"] ?? "";

        $entryDate = date("Y-m-d H:i:s");

        $regulationNumber = $_POST["regulationNumber"] ?? "";

        $insertStatus = insertData($conn, $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber);

        if ($insertStatus) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
    }
?>
<form method='post' action='<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>'>
                            <input type='hidden' name='recordStatus' value='New'>
    
                            <label for='fName'>First Name:</label>
                            <input type='text' name='fName' value='<?= $fName ?>' required>
    
                            <label for='forenameTwo'>Middle Name:</label>
                            <input type='text' name='forenameTwo' value='<?= $forenameTwo ?>'>
                            
                            <label for='surname'>Last Name:</label>
                            <input type='text' name='surname' value='<?= $surname ?>' required>
                            
                            <label for='rankname'>Rank:</label>
                            <input type='text' name='rankname' value='<?= $rankname ?>'>
                            
                            <label for='emailAddress'>Email Address:</label>
                            <input type='email' name='emailAddress' value='<?= $emailAddress ?>'>
                            
                            <label for='gender'>Gender:</label>
                            <select name='gender'>
                                <option value='Male' <?= ($gender == 'Male') ? 'selected' : '' ?>>Male</option>
                                <option value='Female' <?= ($gender == 'Female') ? 'selected' : '' ?>>Female</option>
                            </select>
    
                            <input type='submit' name='submit' value='Submit'>
                        </form>
</body>