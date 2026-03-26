<?php


ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Načtená třídy routeru, která se postará o zpracování URL, bez tohoto řádku by nefungoval řádek 12
require_once "../core/App.php";

// Inicializace aplikace a spuštění procesu routování
$app = new App();  //to co začíná dolarem je proměnná
