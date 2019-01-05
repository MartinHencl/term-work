<?php

class Uzivatel
{
    //ID_UZIVATEL, EMAIL, JMENO, PRIJMENI, TELEFON
    var $idUzivatel;
    var $email;
    var $jmeno;
    var $prijmeni;
    var $role;
    var $telefon;
    var $heslo;

    public function __construct()
    {
        //constructor that takes no parameters
    }

    public static function vytvorUzivatele($idUzivatel, $email, $jmeno, $prijmeni, $role, $telefon) {
        $novyUzivatel = new Uzivatel();

        $novyUzivatel->idUzivatel = $idUzivatel;
        $novyUzivatel->email = $email;
        $novyUzivatel->jmeno = $jmeno;
        $novyUzivatel->prijmeni = $prijmeni;
        $novyUzivatel->role = $role;
        $novyUzivatel->telefon = $telefon;

        return $novyUzivatel;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getPrijmeni()
    {
        return $this->prijmeni;
    }

    /**
     * @param mixed $prijmeni
     */
    public function setPrijmeni($prijmeni)
    {
        $this->prijmeni = $prijmeni;
    }

    /**
     * @return mixed
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * @param mixed $telefon
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getHeslo()
    {
        return $this->heslo;
    }

    /**
     * @param mixed $heslo
     */
    public function setHeslo($heslo)
    {
        $this->heslo = $heslo;
    }

}


