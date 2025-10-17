<?php
// // Require
require_once "includes/connection.inc.php";
require_once "includes/CompanyControl.inc.php";

// // Get the company's data.
// Connect.
PDOControl::connect(CONNSTRING);

// Get the company data.
$dataArray = CompanyControl::getCompanyData("A");
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
            <p><?= $dataArray["website"]; ?></p>
            <p><?= $dataArray["description"]; ?></p>
        </div>
    </main>

</body>

</html>
<?php
// Close
PDOControl::close();
?>