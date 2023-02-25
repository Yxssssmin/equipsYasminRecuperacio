<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Equip;
// use App\Service\ServeiDadesEquips;

class IniciController extends AbstractController{

//    private $equips;
//    public function __construct(ServeiDadesEquips $dades) {
//        $this->equips = $dades->get();
//    }

    #[Route('/', name:'inici')]
    public function inici(ManagerRegistry $doctrine) {
        $repositori = $doctrine->getRepository(Equip::class);
        $equips = $repositori->findAll();
        return $this->render('inici.html.twig', array('equips' => $equips));
    }
}
?>