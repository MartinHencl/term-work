<?php

function vratCelkovouCenu($zacatek, $konec, $cenaDen)
{
    $datetime1 = strtotime($zacatek);
    $datetime2 = strtotime($konec);
    $secs = $datetime2 - $datetime1;// == <seconds between the two times>
    $pocetDni = $secs / 86400;
    return $cenaDen * $pocetDni;
}

?>