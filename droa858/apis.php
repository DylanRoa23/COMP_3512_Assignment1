<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Hyperlink pages</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/api.css">
</head>
<body>
    <?php require_once 'includes/header.inc.php' ?>

    <main id="container">
        <h2>API List</h2>
        <h3>URL</h3>
        <h3 id="description">Description</h3>
        
        <div id="links">
            <a href="api/companies.php">/api/companies.php</a>
            <a href="api/companies.php?ref=ads">/api/companies.php?ref=ads</a>
            <a href="api/portfolio.php?ref=8">/api/portfolio.php?ref=8</a>
            <a href="api/history.php?ref=ads">/api/history.php?ref=ads</a>
        </div>

        <div id="text">
            <p>Returns all companies/stocks</p>
            <p>Returns just a specific company/stock</p>
            <p>Returns all the porfolios for a specific sample customer</p>
            <p>Returns the history information</p>
        </div>
    </main>
</body>
</html>