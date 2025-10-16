<?php require_once 'includes/connection.inc.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/global.css">
    <title>Portfolio Project</title>
</head>
<body>
    <?php require_once 'includes/header.php' ?>
    <?php
        // Connect.
        PDOControl::connect($connString);

        // Test
        $dataArray = CompanyControl::getCompanyData("");
        echo $dataArray;

        // Close
        PDOControl::close();
    ?>
</body>
</html>