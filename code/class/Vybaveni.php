<?php

class Vybaveni
{
    var $idVybaveni;
    var $nazev;
    var $hodnota;

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
    public function getNazevVybaveni()
    {
        return $this->nazev;
    }

    /**
     * @param mixed $nazev
     */
    public function setNazevVybaveni($nazev)
    {
        $this->nazev = $nazev;
    }

    /**
     * @return mixed
     */
    public function getHodnota()
    {
        return $this->hodnota;
    }

    /**
     * @param mixed $hodnota
     */
    public function setHodnota($hodnota)
    {
        $this->hodnota = $hodnota;
    }

}