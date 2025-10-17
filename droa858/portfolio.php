<?php
// // Require
require_once "includes/connection.inc.php";
require_once "includes/UserControl.inc.php";

// Connect
PDOControl::connect(CONNSTRING);

// Test
// $dataArray = UserControl::getUserPortfolios(1);
// while ($row = $dataArray->fetch(PDO::FETCH_ASSOC)) {
//     foreach ($row as $key => $value) {
//         echo "Key: " . $key;
//         echo "<br>";
//         if (is_array($value)) {
//             foreach ($value as $value2) {
//                 echo "Value: " . $value2;
//                 echo "<br>";
//             }
//         } else {
//             echo "Value: " . $value;
//             echo "<br>";
//         }

//     }
// }

// $dataArray = UserControl::getLatestHistory("GOOG");
// foreach ($dataArray as $key => $value) {
//     echo "Key: " . $key;
//     echo "<br>";
//     echo "Value: " . $value;
//     echo "<br>";
// }

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
            $users = UserControl::getAllUsers();
            foreach ($users as $user) {
                $id = $user['id'];
                $name = $user['firstname'] . ", " . $user['lastname'];
                echo "<div class='user'>";
                echo "<p>$name</p>";
                echo "<a class='viewButton' href='portfolio.php?ref=$id'>Portfolio</a>";
                echo "</div>";
            }
            ?>

        </div>
        <div id="summary">
            <h2>Portfolio Summary</h2>
            <div id="placeholder">
                <div>
                    <h3>Companies</h3>

                </div>
                <div>
                    <h3># Shares</h3>
                </div>
                <div>
                    <h3>Total Value</h3>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<?php

// Close the connection.
PDOControl::close();

?>