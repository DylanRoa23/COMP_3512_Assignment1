<?php
// // Require
require_once "includes/connection.inc.php";
require_once "includes/UserControl.inc.php";

PDOControl::connect(CONNSTRING);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/portfolio.css">
</head>
<body>
    <?php require_once 'includes/header.inc.php' ?>

    <main class="container">
        <div id="customer">
            <h2>Customers</h2>
            <h3>Name</h3>

            <?php require_once 'includes/customerlist.inc.php'; ?>

        </div>
        <div id="summary">
            <h2 id="message">Please select a customer's portfolio</h2>
        </div>
    </main>
</body>
</html>
<?php

// Close the connection.
PDOControl::close();

?>