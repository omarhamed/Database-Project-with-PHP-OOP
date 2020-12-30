<?php

require_once("Database.php");

$db = new Database();
echo $db->isConnected()? "Connected"."<br>" : "Not Connected"."<br>";

if ( !$db->isConnected() ) {
	echo $db->getError();
	die("Unable to connect to Database");
}

$db->query("SELECT *FROM tbl_oop_test");
var_dump($db->setResults());
echo "<br>";
echo $db->rowCount()."<br>";

var_dump($db->single());

$db->query("SELECT *FROM tbl_oop_test WHERE id=:id");

$db->bind(':id',2);

var_dump($db->single());