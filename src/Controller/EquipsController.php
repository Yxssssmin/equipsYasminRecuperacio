<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ServeiDadesEquips;

class EquipsController extends AbstractController {

    private $equips;
    public function __construct(ServeiDadesEquips $dades) {
        $this->equips = $dades->get();
    } 

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