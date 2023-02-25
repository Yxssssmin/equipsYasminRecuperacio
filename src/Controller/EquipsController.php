<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ServeiDadesEquips;
use App\Entity\Equip;
use Doctrine\Persistence\ManagerRegistry;

class EquipsController extends AbstractController {

//    private $equips;
//    public function __construct(ServeiDadesEquips $dades) {
//        $this->equips = $dades->get();
//    } 

//    #[Route('/equip/{codi<\d+>?1}',name:'dades_equip')]
//    public function dades($codi) {
//        $resultat = array_filter($this->equips, 
//            function($equip) use ($codi) {
//                return $equip["codi"] == $codi;
//            });
//
//            return $this->render('dades_equip.html.twig',
//            array('equip' => array_shift($resultat)));
//
//    }

    #[Route('/equip/inserir', name: 'inserir')]
    public function inserir(ManagerRegistry $doctrine) {
        
        $entityManager = $doctrine->getManager();
        $equip = new Equip();
        $equip->setNom("Simarrets2");
        $equip->setCicle("DAW");
        $equip->setCurs("22/23");
        $equip->setNota("9");
        $equip->setImatge("equipPerDefecte.png");

        $entityManager->persist($equip);
        $success = true;

        try {
            $entityManager->flush();
            return $this->render('inserir_equip.html.twig', array('equip' => $equip, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_equip.html.twig', array('equip' => $equip, 'error' => $e->getMessage()));
        }
    }

    #[Route('/equip/inserirmultiple', name: 'inserir_multiple')]
    public function inserirmultiple(ManagerRegistry $doctrine) {

        $entityManager = $doctrine->getManager();
        $equip1 = new Equip();
        $equip1->setNom("Equip rosa");
        $equip1->setCicle("DAW");
        $equip1->setCurs("22/23");
        $equip1->setNota("5");
        $equip1->setImatge("bartSimpson.png");
        $entityManager->persist($equip1);

        $equip2 = new Equip();
        $equip2->setNom("Equip gris");
        $equip2->setCicle("DAM");
        $equip2->setCurs("22/23");
        $equip2->setNota("7.5");
        $equip2->setImatge("homerSimpson.png");
        $entityManager->persist($equip2);

        $equip3 = new Equip();
        $equip3->setNom("Equip groc");
        $equip3->setCicle("ASIX");
        $equip3->setCurs("22/23");
        $equip3->setNota("4");
        $equip3->setImatge("lisaSimpson.png");
        $entityManager->persist($equip3);

        $equips = array($equip1, $equip2, $equip3);

        try {
            $entityManager->flush();
            return $this->render('inserir_equip_multiple.html.twig', array('equips' => $equips, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_equip_multiple.html.twig', array('equips' => $equips, 'error' => $e->getMessage()));
        }

    }

    #[Route('/equip/{id}', name:'dades_equip')]
    public function equip($id, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Equip::class);
        $equip = $repositori->find($id);
        if($equip){
            return $this->render('dades_equip.html.twig', array('equip' =>$equip));
        } else {
            return $this->render('dades_equip.html.twig', array('equip' =>NULL));
        }
    }

    #[Route('/equip/nota/{nota}', name:'filtrar_nota')]
    public function nota($nota, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Equip::class);
        $equips = $repositori->findAll();
         $a = array();

        forEach ($equips as $equip ){
            if ($equip->getNota() >= $nota){
                array_push($a, $equip);
            }
        }

        arsort($a);
        if($a){
            return $this->render('inici.html.twig', array('equips' =>$a));
        } else {
            return $this->render('inici.html.twig', array('equips' =>NULL));
        }
    }

    
}

?>