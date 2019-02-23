<?php
try {
	$bdd = new PDO('pgsql:host=tuxa.sme.utc;dbname=dbna18a005', 'na18a005', 'lKlCeaK4', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}
?>
