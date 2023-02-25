<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EquipsController extends AbstractController {

    private $equips = array(
        array("codi" => "1", "nom" => "Equip Roig", "cicle" => "DAW", "curs" => "22/23", "membres" => array("Elena", "Vicent", "Joan", "Maria")),
        array("codi" => "2", "nom" => "Equip Taronja", "cicle" => "ASIX", "curs" => "21/22", "membres" => array("Marina", "Marcos", "Pablo", "Yasmin")),
        array("codi" => "3", "nom" => "Equip Verd", "cicle" => "SMX", "curs" => "20/21", "membres" => array("Fran", "Pepe", "Jose", "Jaume")),
        array("codi" => "4", "nom" => "Equip Blau", "cicle" => "DAM", "curs" => "19/20", "membres" => array("Sergi", "Miguel", "Juan", "Marta"))
    );

    #[Route('/equip/{codi<\d+>?1}',name:'dades_equip')]
    public function dades($codi) {
        $resultat = array_filter($this->equips, 
            function($equip) use ($codi) {
                return $equip["codi"] == $codi;
            });

            return $this->render('dades_equip.html.twig',
            array('equip' => array_shift($resultat)));

    }
}

?>