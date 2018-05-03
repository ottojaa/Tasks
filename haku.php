<?php
require_once("config/config.php");
    if(isset($_POST['submit'])) {
        $search_value = $_POST["hinta"];
        $search_name = $_POST["nimi"];

        $ehdot=array(':nimi'=>'%'.$search_name.'%', ':hinta'=>$search_value);
        $kysely = $DBH->prepare("SELECT * FROM vk_tuotteet WHERE vk_tuotteet.hinta < :hinta AND vk_tuotteet.nimi LIKE :nimi");
        $kysely->execute($ehdot);
        $kysely->setFetchMode(PDO::FETCH_OBJ);

        while ($tuoteOlio = $kysely->fetch()) {
            echo"<br />4. tID = ". $tuoteOlio->tID . "  " . $tuoteOlio->nimi .", hinta " . $tuoteOlio->hinta ." €";
        }
    }
?>