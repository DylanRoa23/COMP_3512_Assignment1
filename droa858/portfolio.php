<?php
// // Require
require_once "includes/connection.inc.php";
require_once "includes/UserControl.inc.php";

// Connect
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
            <div id="portfolioSummary">
                <h2>Portfolio Summary</h2>
                <div id="companies">
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
                <div id="numShares">
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
                <div id="totalVal">
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

            <div id="details">
                <h2>Portfolio Details</h2>
                <div id="section">
                    <h3 class="symbolSection">Symbol</h3>
                    <h3 class="nameSection">Names</h3>
                    <h3 class="sectorSection">Sector</h3>
                    <h3 class="amountSection">Amount</h3>
                    <h3 class="valueSection">Value</h3>
                </div>
                <div class="symbolSection">
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getUserSymbol($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div class="nameSection">
                    <?php 
                        if (isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getUserCompanyName($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div class="sectorSection">
                    <?php
                        if(isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getSector($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div class="amountSection">
                    <?php
                        if(isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getSymbolAmount($id);
                        } else {
                            echo "<p>Nothing Found</p>";
                        }
                    ?>
                </div>
                <div class="valueSection">
                    <?php
                        if(isset($_GET['ref'])) {
                            $id = (int) $_GET['ref'];
                            echo UserControl::getSymbolValue($id);
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