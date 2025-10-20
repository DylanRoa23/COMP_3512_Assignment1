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

// Echo JSON
echo CompanyControl::getAllCompanies();

// Close
PDOControl::close();