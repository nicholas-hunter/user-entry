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

        $regulationNumber = $recordStatus = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Search"])) {
            $recordStatus = $_POST["recordStatus"];
            $regulationNumber = $_POST["regulationNumber"];

            // Perform search here
            $searchedData = fetchData($regulationNumber, $dbconnection);

            if ($searchedData) {
                echo "Record found. Display the information or redirect accordingly.";
                // You may redirect or display information here
            } else {
                echo "Record not found. Display appropriate message or redirect.";
                // You may redirect or display message here
            }
        }
    ?>

    <form method="post" action="search.php">
        <label for="recordStatus">Select Record Status:</label>
        <select name="recordStatus" id="recordStatus" required>
            <option value="New">New</option>
            <option value="Amend">Amend</option>
            <option value="Archive">Archive</option>
        </select>
        <br><br>

        <label for="regulationNumber">Regulation Number:</label>
        <input type="text" name="regulationNumber" value="<?= htmlspecialchars($regulationNumber) ?>" required>

        <input type="submit" name="Search" value="Search">
    </form>
</body>
</html>
