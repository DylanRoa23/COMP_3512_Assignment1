<?php
require_once 'includes/portfolioConnection.inc.php';

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
            <?php
            $users = UserNames::getAllUsers();
            foreach ($users as $user) {
                $id = htmlspecialchars($user['id']);
                $name = htmlspecialchars($user['firstname'] . ", " . $user['lastname']);
                echo "<div class='user'>";
                echo "<p>$name</p>";
                echo "<a class='viewButton' href='portfolio.php?ref=$id'>View Portfolio</a>";
                echo "</div>";
            }
            ?>

        </div>
        <div id="summary">
            <h2 id="message">Please select a customer's portfolio</h2>
        </div>
    </main>
</body>
</html>