<?php

class Vozidlo
{
    var $idVozidla;
    var $jmeno;
    var $cena;
    var $puvodniNajeto;
    var $znacka_vozu_id_znacka_vozu;

    /**
     * Vozidlo constructor.
     */
    public function __construct()
    {
    }

    public static function vytvorVozidlo($idVozidla, $jmeno, $cena, $puvodniNajeto, $znacka_vozu_id_znacka_vozu) {
        $novyVuz = new Vozidlo();
        $novyVuz->idVozidla = $idVozidla;
        $novyVuz->jmeno = $jmeno;
        $novyVuz->cena = $cena;
        $novyVuz->puvodniNajeto = $puvodniNajeto;
        $novyVuz->znacka_vozu_id_znacka_vozu = $znacka_vozu_id_znacka_vozu;
        return $novyVuz;
    }



    /**
     * @return mixed
     */
    public function getIdVozidla()
    {
        return $this->idVozidla;
    }

    /**
     * @param mixed $idVozidla
     */
    public function setIdVozidla($idVozidla)
    {
        $this->idVozidla = $idVozidla;
    }

    /**
     * @return mixed
     */
    public function getJmeno()
    {
        return $this->jmeno;
    }

    /**
     * @param mixed $jmeno
     */
    public function setJmeno($jmeno)
    {
        $this->jmeno = $jmeno;
    }

    /**
     * @return mixed
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * @param mixed $cena
     */
    public function setCena($cena)
    {
        $this->cena = $cena;
    }

    /**
     * @return mixed
     */
    public function getPuvodniNajeto()
    {
        return $this->puvodniNajeto;
    }

    /**
     * @param mixed $puvodniNajeto
     */
    public function setPuvodniNajeto($puvodniNajeto)
    {
        $this->puvodniNajeto = $puvodniNajeto;
    }

    /**
     * @return mixed
     */
    public function getZnackaVozuIdZnackaVozu()
    {
        return $this->znacka_vozu_id_znacka_vozu;
    }

    /**
     * @param mixed $znacka_vozu_id_znacka_vozu
     */
    public function setZnackaVozuIdZnackaVozu($znacka_vozu_id_znacka_vozu)
    {
        $this->znacka_vozu_id_znacka_vozu = $znacka_vozu_id_znacka_vozu;
    }

}