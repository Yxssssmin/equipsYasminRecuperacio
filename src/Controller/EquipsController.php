<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipsController {

    private $equips = array(
        array("codi" => "1", "nom" => "Equip Roig", "cicle" => "DAW", "curs" => "22/23", "membres" => "Elena, Vicent, Joan, Maria"),
        array("codi" => "2", "nom" => "Equip Taronja", "cicle" => "ASIX", "curs" => "21/22", "membres" => "Marina, Marcos, Pablo, Yasmin"),
        array("codi" => "3", "nom" => "Equip Verd", "cicle" => "SMX", "curs" => "20/21", "membres" => "Fran, Pepe, Jose, Jaume"),
        array("codi" => "4", "nom" => "Equip Blau", "cicle" => "DAM", "curs" => "19/20", "membres" => "Sergi, Miguel, Juan, Marta"),
    );

    #[Route('/equip/{codi<\d+>?1}',name:'dades_equip')]
    public function dades($codi) {
        $resultat = array_filter($this->equips, 
            function($equip) use ($codi) {
                return $equip["codi"] == $codi;
            });

        if(count($resultat) > 0) {
            $resposta = "";
            $resultat = array_shift($resultat); #torna el primer element
            $resposta .= "<ul><li>" . $resultat["codi"] . "</li>" . 
                                "<li>" . $resultat["nom"] . "</li>" . 
                                "<li>" . $resultat["cicle"] . "</li>" . 
                                "<li>" . $resultat["curs"] . "</li>" . 
                                "<li>" . $resultat["membres"] . "</li></ul>";

            return new Response("<html><body>$resposta</body></html>");
        } else {
            return new Response("No s'ha trobat l'equip: $codi");
        }
    }
}

?>