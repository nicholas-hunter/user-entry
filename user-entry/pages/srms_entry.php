<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles2.css">
    <title>Your Title Here</title>
</head>
<body>

<?php



include("config.php");

function fetchData($regulationNumber, $conn) 
{
    $sql = "SELECT * FROM srsmPersonnel WHERE regulationNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regulationNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function insertData($conn, $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber)
{
    echo  "Insert Data".$fName.$forenameTwo.$surname.$rankname.$emailAddress.$gender.$entryDate.$regulationNumber;
    $sql = "INSERT INTO srsmPersonnel (fName, forenameTwo, surname, rankname, emailAddress, gender, entryDate, regulationNumber)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber);

    return $stmt->execute();
}

// Initialize variables
$fName = $forenameTwo = $surname = $rankname = $emailAddress = $gender = $entryDate = $regulationNumber = $recordStatus = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $recordStatus = isset($_POST["recordStatus"]) ? $_POST["recordStatus"] : "";
    if ($recordStatus == "New") 
    {
        $regulationNumber = isset($_POST["regulationNumber"]) ? $_POST["regulationNumber"] : "";

        // Search for the regulation number in the database
        $searchedData = fetchData($regulationNumber, $conn);

        if ($searchedData) 
        {
            echo "Record is already in the system";
            extract($searchedData);
        } 
        else 
        {
            echo "Record not found for the given regulation number. Kindly enter the necessary information in the fields provided below.";

            // Handle form submission for new records
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) 
            {
                $fName = $_POST["fName"] ?? "";
                $forenameTwo = $_POST["forenameTwo"] ?? "";
                $surname = $_POST["surname"] ?? "";
                $rankname = $_POST["rankname"] ?? "";
                $emailAddress = $_POST["emailAddress"] ?? "";
                $gender = $_POST["gender"] ?? "";

                $entryDate = date("Y-m-d H:i:s");

                $insertStatus = insertData($conn, $fName, $forenameTwo, $surname, $rankname, $emailAddress, $gender, $entryDate, $regulationNumber);
                
                echo $insertStatus;
                if ($insertStatus) 
                {
                    echo "Record inserted successfully.";
                } 
                else 
                {
                    echo "Error inserting record: " . $stmt->error;
                }
            }

            // Additional HTML form for entering details
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
            <?php
        }
    } 
    elseif ($recordStatus == "Amend") 
    {
        // Update the database
        $updatedfName = $_POST["fName"] ?? null;
        $updatedforenameTwo = $_POST["forenameTwo"] ?? null;
        $updatedsurname = $_POST["surname"] ?? null;
        $updatedrankname = $_POST["rankname"] ?? null;
        $updatedemailAddress = $_POST["emailAddress"] ?? null;
        $updatedgender = $_POST["gender"] ?? null;

        $entryDate = date("Y-m-d H:i:s");

        $sql = "UPDATE srsmPersonnel
                SET fName=?, forenameTwo=?, surname=?, rankname=?, emailAddress=?, gender=?, entryDate=?
                WHERE regulationNumber=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $updatedfName, $updatedforenameTwo, $updatedsurname, $updatedrankname, $updatedemailAddress, $updatedgender, $entryDate, $regulationNumber);

        if ($stmt->execute()) 
        {
            echo "Record updated successfully.";
        } 
        else 
        {
            echo "Error updating record: " . $stmt->error;
        }
    }
}
?>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <label for="recordStatus">Select Record Status:</label>
    <select name="recordStatus" id="recordStatus" required>
        <option value="New">New</option>
        <option value="Amend">Amend</option>
        <option value="Archive">Archive</option>
    </select>
    <br><br>

    <label for="regulationNumber">Regulation Number:</label>
    <input type="text" name="regulationNumber" value="<?= htmlspecialchars($regulationNumber) ?>" required>
    <input type="submit" value="Search">
</form>

<?php
// Display retrieved data in editable fields
if ($recordStatus == "Search") 
{
    echo "<h2>SRMS Information</h2>";
    ?>
    <form method='post' action='<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>'>
        <input type='hidden' name='recordStatus' value='Update'>
        <input type='hidden' name='regulationNumber' value='<?= $regulationNumber ?>'>

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

        <input type='submit' value='Submit'>
    </form>
    <?php 
}
?>



</body>
</html>
