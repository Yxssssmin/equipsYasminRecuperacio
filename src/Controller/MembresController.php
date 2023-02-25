<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equip;
use App\Entity\Membre;
use App\Service\ServeiDadesEquips;

use Doctrine\Persistence\ManagerRegistry;
class MembresController extends AbstractController {


    #[Route('/membre/inserir', name:'inserir_membre')]
    public function inserir_membre(ManagerRegistry $doctrine) {
        
        $repositori = $doctrine->getRepository(Equip::class);        
        $equip = $repositori->find(1);

        $entityManager = $doctrine->getManager();
        $error = null;

        $membre = new Membre();
        $membre->setNom("Sarah");
        $membre->setCognoms("Connor");
        $membre->setEmail("sarahconnor@skynet.com");
        $membre->setImatgePerfil("membre.png");
        $membre->setDataNaixement(new \DateTime("1963-11-29"));
        $membre->setNota(9.7);
        $membre->setEquip($equip);

        $entityManager->persist($membre);

        try {
            $entityManager->flush();
            return $this->render('inserir_membre.html.twig', array('membre' => $membre, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_membre.html.twig', array('membre' => $membre, 'error' => $e->getMessage()));
        }

    }

}



?>