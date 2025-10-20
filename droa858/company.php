<?php
// // Require
require_once "includes/connection.inc.php";
require_once "includes/CompanyControl.inc.php";

// // Get the company's data.
// Connect.
PDOControl::connect(CONNSTRING);

// Get the company data.
if (isset($_GET["symbol"])) {
    $dataArray = CompanyControl::getCompanyData($_GET["symbol"]);
    $historyStatement = CompanyControl::getCompanyHistory($_GET["symbol"]);
}
else{
    die("Error: No company data received.");
}
    
// $dataArray = CompanyControl::getCompanyData("A");
// foreach ($dataArray as $key => $value) {
//     echo "Key: " . $key;
//     echo "<br>";
//     echo "Value: " . $value;
//     echo "<br>";
// }
// $dataArray["financials"] = json_decode($dataArray["financials"], true);
// foreach ($dataArray["financials"] as $key => $value) {
//     echo "Key: " . $key;
//     echo "<br>";
//     foreach ($value as $value2) {
//         echo "Value: " . $value2;
//         echo "<br>";
//     }
// }

// Initialize stats.
$hhigh = null;
$hlow = null;
$totalVolume = 0;
$historyCount = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/company.css">
    <title>Portfolio Project</title>
</head>

<body>
    <?php require_once 'includes/header.inc.php'; ?>
    <main>
        <div>
            <h2>Company Info</h2>
        </div>
        <div id="info">
            <h1><?= $dataArray["name"]; ?> (<?= $dataArray["symbol"]; ?>)</h1>
            <p><?= $dataArray["sector"]; ?></p>
            <p><?= $dataArray["subindustry"]; ?></p>
            <p>Based in <?= $dataArray["address"]; ?></p>
            <p><?= $dataArray["exchange"]; ?></p>
            <p>Website: <a href="<?= $dataArray["website"]; ?>"><?= $dataArray["website"]; ?></a></p>
            <p><?= $dataArray["description"]; ?></p>
        </div>
        <div id="displaygrid">
            <div id="history">
                <h2>History (3M)</h2>
                <div id="hgrid">
                    <strong>Date</strong>
                    <strong>Volume</strong>
                    <strong>Open</strong>
                    <strong>Close</strong>
                    <strong>High</strong>
                    <strong>Low</strong>
                    <?php
                        foreach ($historyStatement as $row){ ?>
                            <p><?= $row["date"]; ?></p>
                            <p><?= $row["volume"]; ?></p>
                            <p><?= number_format($row["open"], 2); ?></p>
                            <p><?= number_format($row["close"], 2); ?></p>
                            <p><?= number_format($row["high"], 2); ?></p>
                            <p><?= number_format($row["low"], 2); ?></p>

                            <?php
                            // Update stats.

                            // If history high is not set, or if it is lower,
                            if(!isset($hhigh) || $hhigh < $row["high"]){
                                
                                // Update to this row's high.
                                $hhigh = $row["high"];

                            }

                            // If history low is not set,
                            if(!isset($hlow) || $hlow > $row["low"]){
                                
                                // Set it.
                                $hlow = $row["low"];

                            }

                            // Add to total
                            $totalVolume += $row["volume"];

                            // Add to historyCount.
                            $historyCount++;

                        }
                    ?>
                </div>
            </div>
            <div id="stats">

            </div>
        </div>
    </main>

</body>

</html>
<?php
// Close
PDOControl::close();
?>