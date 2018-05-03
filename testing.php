<?php
require_once("config/config.php");
echo nl2br("\n\nTEHTÄVÄ 1 \n\n");

//Kysytään montako tuotetta on kannassa. Käytä $DBH eli config.php:ssä luotua yhteysoliota
//(Data Base Handle)
$kysely1 = $DBH->prepare("SELECT COUNT(*) FROM vk_tuotteet");
$kysely1->execute();
$tulos = $kysely1->fetch();
echo "1. vk_tuotteet-taulussa on " . $tulos["COUNT(*)"] . " riviä.";

echo nl2br("\n\nTEHTÄVÄ 2 \n\n");

$kysely2 = $DBH->prepare("SELECT * FROM vk_tuotteet");
$kysely2->execute();

// käsitellään tulostaulun rivit yksi kerrallaan
while ($rivi = $kysely2->fetch()) {
    // $rivi["nimi"] sisältää nimen (assosiatiivinen taulukko eli indeksit ovat nimikoitu
    // $rivi["hinta"] sisältää hinnan
    echo"<br />2. " .htmlspecialchars($rivi["nimi"]) . "  "  . $rivi["hinta"] . "€";
}

echo nl2br("\n\nTEHTÄVÄ 3 \n\n");

$tuoteID=2;
$kysely3 = $DBH->prepare("SELECT vk_tuotteet.nimi, vk_tuotteet.tuotekoodi FROM vk_tuotteet WHERE vk_tuotteet.tID = :haluttuID");

$kysely3->bindParam(':haluttuID', $tuoteID);
$kysely3->execute();
$kysely3->setFetchMode(PDO::FETCH_OBJ);
$ekaTulosOlio = $kysely3->fetch();

echo ("<br />3. Haluttu tID = $tuoteID : " . $ekaTulosOlio->nimi .", tuotekoodi  " . $ekaTulosOlio->tuotekoodi );

echo nl2br("\n\nTEHTÄVÄ 4 \n\n");

$ehdot=array(':tID'=>5, ':hinta'=>50);
$kysely4 = $DBH->prepare("SELECT * FROM vk_tuotteet WHERE vk_tuotteet.hinta < :hinta AND vk_tuotteet.tID < :tID");
// suoritetaan kysely tuotekoodien arvolla 3 tai 4
$kysely4->execute($ehdot);
$kysely4->setFetchMode(PDO::FETCH_OBJ);

while ($tuoteOlio = $kysely4->fetch()) {
    echo"<br />4. tID = ". $tuoteOlio->tID . "  " . $tuoteOlio->nimi .", hinta " . $tuoteOlio->hinta ." €";
}


?>


