<?php
session_start();

$_SESSION["idProj"] = $_GET["id"];

header("Location: prjct_manager.php");