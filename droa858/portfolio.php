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

            <?php require_once 'includes/customerlist.inc.php'; ?>

        </div>
        <div id="summary">
            <div id="portfolioSummary">
                <h2>Portfolio Summary</h2>
                <div>
                    <h3>Companies</h3>
                        <?php 
                            if (isset($_GET['ref'])) {
                                $id = (int) $_GET['ref'];
                                $companyCount = UserControl::countUserCompanies($id);
                                echo "<p>$companyCount</p>";
                            } else {
                                echo "<p>Nothing Found</p>";
                            }
                        ?>
                </div>
                <div>
                    <h3># Shares</h3>
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            $totalShares = UserControl::countUserShares($id);
                            echo "<p>$totalShares</p>";
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div>
                    <h3>Total Value</h3>
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            $portfolioValue = UserControl::getUserPortfolioValue($id);
                            echo "<p>$" . number_format($portfolioValue, 0) . "</p>";
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
            </div>

            <div>
                <h2>Portfolio Details</h2>
                <div class="details">
                    <h3>Symbol</h3>
                    <h3>Names</h3>
                    <h3>Sector</h3>
                    <h3>Amount</h3>
                    <h3>Value</h3>
                </div>
                <div>
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getUserSymbol($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div>
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getUserCompanyName($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getSector($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
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