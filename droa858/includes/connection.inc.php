<?php
/**
 * Prepares for a PDO connection. Can be called by php pages prior to PDO connection.
 */

// Require
require_once "PDOControl.inc.php";

// Initialize
const CONNSTRING = "sqlite:data/stocks.db";