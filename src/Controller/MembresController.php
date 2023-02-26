<?php
namespace App\Controller;
use App\Form\MembreEditarType;
use App\Form\MembreNouType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Equip;
use App\Entity\Membredos;
use App\Service\ServeiDadesEquips;

use Doctrine\Persistence\ManagerRegistry;
class MembresController extends AbstractController {

    #[Route('/membre/editar/{codi}' ,name:'editarMembre', requirements: ['codi' => '\d+'])]
    public function editar(Request $request, $codi, ManagerRegistry $doctrine) {

        $membre = new Membredos();
        $repositori = $doctrine->getRepository(Membredos::class);
        $membre = $repositori->find($codi);
        $imatgeOld = $membre->getImatgePerfil();

        $formulari = $this->createForm(MembreEditarType::class, $membre);

        $formulari->handleRequest($request);

        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $membre = $formulari->getData();

            $imatge = $formulari->get('imatgePerfil')->getData();

            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/membres/";
                unlink("img/membres/".$imatgeOld);

                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('editar_membre.html.twig', array('membre' => $membre, 'error' => $e->getMessage()));
                }
                $membre->setImatgePerfil($nomFitxer);
            }


            $entityManager = $doctrine->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('editar_membre.html.twig', array('formulari' => $formulari->createView(), 'membre' => $membre));
    }

    #[Route('/membre/nou' ,name:'nou_membre')]
    public function nou(Request $request, ManagerRegistry $doctrine)
    {
        $membre = new Membredos();
        
        $formulari = $this->createForm(MembreNouType::class, $membre);
        
        $formulari->handleRequest($request);

        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $membre = $formulari->getData();

            $imatge = $formulari->get('imatgePerfil')->getData();

            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/";
                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('nou_membre.html.twig', array('membre' => $membre, 'error' => $e->getMessage()));
                }
                $membre->setImatgePerfil($nomFitxer);
            } else {
                $membre->setImatgePerfil('imagenPorDefecto.png');
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('inici');
        }
        return $this->render('nou_membre.html.twig', array('formulari' => $formulari->createView()));
    }

    #[Route('/membre/inserir', name:'inserir_membre')]
    public function inserir_membre(ManagerRegistry $doctrine) {
        
        $repositori = $doctrine->getRepository(Equip::class);        
        $equip = $repositori->find(39);

        $entityManager = $doctrine->getManager();
        $error = null;

        $membre = new Membredos();
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