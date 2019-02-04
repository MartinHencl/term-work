<?php


/*****************************************/
// pouziti = $param_stav = StavObjednavky::getObjednano()->getText();
final class StavObjednavky {
    private static $objednano, $schvaleno, $vyzvednuto, $vraceno;
    private $text;

    /**
     * StavObjednavky constructor.
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public static function getObjednano()
    {
        if(!isset(self::$objednano)){
            self::$objednano = new self("objednano");
        }
        return self::$objednano;
    }

    /**
     * @return mixed
     */
    public static function getSchvaleno()
    {
        if(!isset(self::$schvaleno)){
            self::$schvaleno = new self("schvaleno");
        }
        return self::$schvaleno;
    }

    /**
     * @return mixed
     */
    public static function getVyzvednuto()
    {
        if(!isset(self::$vyzvednuto)){
            self::$vyzvednuto = new self("vyzvednuto");
        }
        return self::$vyzvednuto;
    }

    /**
     * @return mixed
     */
    public static function getVraceno()
    {
        if(!isset(self::$vraceno)){
            self::$vraceno = new self("vraceno");
        }
        return self::$vraceno;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }


}