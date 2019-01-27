<?php

class Znacka
{
    var $idZnacky;
    var $znacka;

    public function __construct()
    {
    }

    public static function vytvorZnacku($idZnacky, $znacka) {
        $novaZnacka = new Znacka();
        $novaZnacka->idZnacky = $idZnacky;
        $novaZnacka->znacka = $znacka;
        return $novaZnacka;
    }
    /**
     * @return mixed
     */
    public function getIdZnacky()
    {
        return $this->idZnacky;
    }

    /**
     * @param mixed $idZnacky
     */
    public function setIdZnacky($idZnacky)
    {
        $this->idZnacky = $idZnacky;
    }

    /**
     * @return mixed
     */
    public function getZnacka()
    {
        return $this->znacka;
    }

    /**
     * @param mixed $znacka
     */
    public function setZnacka($znacka)
    {
        $this->znacka = $znacka;
    }



}