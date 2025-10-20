<?php
// // Require
require_once "../includes/connection.inc.php";
require_once "../includes/CompanyControl.inc.php";

// Set header
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

// // Get the company's data.
// Connect.
PDOControl::connect("sqlite:../data/stocks.db");

if (isset($_GET["ref"])) {
    // Echo JSON
    echo CompanyControl::getJSON($_GET["ref"]);
} else {
    // Echo JSON
    echo CompanyControl::getJSON();
}

// Close
PDOControl::close();