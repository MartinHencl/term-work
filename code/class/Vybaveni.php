<?php

class Vybaveni
{
    var $idVybaveni;
    var $nazev;

    public function __construct()
    {
    }

    public static function vytvorVybaveni($idVybaveni, $nazev) {
        $noveVybaveni = new Vybaveni();
        $noveVybaveni->idVybaveni = $idVybaveni;
        $noveVybaveni->nazev = $nazev;
        return $noveVybaveni;
    }

    /**
     * @return mixed
     */
    public function getIdVybaveni()
    {
        return $this->idVybaveni;
    }

    /**
     * @param mixed $idVybaveni
     */
    public function setIdVybaveni($idVybaveni)
    {
        $this->idVybaveni = $idVybaveni;
    }

    /**
     * @return mixed
     */
    public function getNazev()
    {
        return $this->nazev;
    }

    /**
     * @param mixed $nazev
     */
    public function setNazev($nazev)
    {
        $this->nazev = $nazev;
    }

}