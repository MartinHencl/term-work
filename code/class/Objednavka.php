<?php

class Objednavka
{
    var $idObjednavky;
    var $datumVzniku;
    var $datumZacatku;
    var $datumKonce;
    var $najeto;
    var $stav;
    var $idUzivatel;
    var $idVozu;

    /**
     * Objednavka constructor.
     */
    public function __construct()
    {
    }

    public static function vytvorObjednavku($idObjednavky, $datumVzniku, $datumZacatku, $datumKonce, $stav, $idUzivatel, $idVozu) {
        $novaObjednavka = new Objednavka();
        $novaObjednavka->idObjednavky = $idObjednavky;
        $novaObjednavka->datumVzniku = $datumVzniku;
        $novaObjednavka->datumZacatku = $datumZacatku;
        $novaObjednavka->datumKonce = $datumKonce;
        $novaObjednavka->stav = $stav;
        $novaObjednavka->idUzivatel = $idUzivatel;
        $novaObjednavka->idVozu = $idVozu;
        return $novaObjednavka;
    }

    /**
     * @return mixed
     */
    public function getIdObjednavky()
    {
        return $this->idObjednavky;
    }

    /**
     * @param mixed $idObjednavky
     */
    public function setIdObjednavky($idObjednavky)
    {
        $this->idObjednavky = $idObjednavky;
    }

    /**
     * @return mixed
     */
    public function getDatumVzniku()
    {
        return $this->datumVzniku;
    }

    /**
     * @param mixed $datumVzniku
     */
    public function setDatumVzniku($datumVzniku)
    {
        $this->datumVzniku = $datumVzniku;
    }

    /**
     * @return mixed
     */
    public function getDatumZacatku()
    {
        return $this->datumZacatku;
    }

    /**
     * @param mixed $datumZacatku
     */
    public function setDatumZacatku($datumZacatku)
    {
        $this->datumZacatku = $datumZacatku;
    }

    /**
     * @return mixed
     */
    public function getDatumKonce()
    {
        return $this->datumKonce;
    }

    /**
     * @param mixed $datumKonce
     */
    public function setDatumKonce($datumKonce)
    {
        $this->datumKonce = $datumKonce;
    }

    /**
     * @return mixed
     */
    public function getNajeto()
    {
        return $this->najeto;
    }

    /**
     * @param mixed $najeto
     */
    public function setNajeto($najeto)
    {
        $this->najeto = $najeto;
    }

    /**
     * @return mixed
     */
    public function getStav()
    {
        return $this->stav;
    }

    /**
     * @param mixed $stav
     */
    public function setStav($stav)
    {
        $this->stav = $stav;
    }

    /**
     * @return mixed
     */
    public function getIdUzivatel()
    {
        return $this->idUzivatel;
    }

    /**
     * @param mixed $idUzivatel
     */
    public function setIdUzivatel($idUzivatel)
    {
        $this->idUzivatel = $idUzivatel;
    }

    /**
     * @return mixed
     */
    public function getIdVozu()
    {
        return $this->idVozu;
    }

    /**
     * @param mixed $idVozu
     */
    public function setIdVozu($idVozu)
    {
        $this->idVozu = $idVozu;
    }


}