<?php 
namespace App\Service;

class ServeiDadesEquips {

    private $equips = array(
        array("img" => "homerSimpson.png", "codi" => "1", "nom" => "Equip Roig", "cicle" => "DAW", "curs" => "22/23", "membres" => array("Elena", "Vicent", "Joan", "Maria")),
        array("img" => "maggieSimpson.png", "codi" => "2", "nom" => "Equip Taronja", "cicle" => "ASIX", "curs" => "21/22", "membres" => array("Marina", "Marcos", "Pablo", "Yasmin")),
        array("img" => "margeSimpson.png", "codi" => "3", "nom" => "Equip Verd", "cicle" => "SMX", "curs" => "20/21", "membres" => array("Fran", "Pepe", "Jose", "Jaume")),
        array("img" => "bartSimpson.png", "codi" => "4", "nom" => "Equip Blau", "cicle" => "DAM", "curs" => "19/20", "membres" => array("Sergi", "Miguel", "Juan", "Marta"))
    );

    public function get() {
        return $this->equips;
    }
}
?>