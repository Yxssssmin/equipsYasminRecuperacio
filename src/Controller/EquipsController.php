<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

#[Route('/equip/editar/{codi}' ,name:'editarEquip', requirements: ['codi' => '\d+'])]
public function editar(Request $request, $codi, ManagerRegistry $doctrine) {

    $equip = new Equip();
    $repositori = $doctrine->getRepository(Equip::class);
    $equip = $repositori->find($codi);
    $formulari = $this->createFormBuilder($equip)
        ->add('nom', TextType::class)
        ->add('cicle', TextType::class)
        ->add('curs', TextType::class)
        ->add('imatge', FileType::class,array('required' => false, 'mapped' => false))
        ->add('nota', NumberType::class)
        ->add('save', SubmitType::class, array('label' => 'Enviar'))
        ->getForm();
    $formulari->handleRequest($request);

    if ($formulari->isSubmitted() && $formulari->isValid()) {
        
        $equip = $formulari->getData();

        $imatge = $formulari->get('imatge')->getData();


        //$imatge = $equip->getImatge();
        if ($imatge) {
            $nomFitxer = $imatge->getClientOriginalName();
            $directori = $this->getParameter('kernel.project_dir') . "/public/img/equips/";
            try {
                $imatge->move($directori,$nomFitxer);
            } catch (FileException $e) {
                return $this->render('editar_equip.html.twig', array('equip' => $equip, 'error' => $e->getMessage()));
            }
            $equip->setImatge($nomFitxer);
        } else {
            $equip->setImatge('imagenPorDefecto.png');
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($equip);
        $entityManager->flush();

        return $this->redirectToRoute('inici');
    }
    return $this->render('editar_equip.html.twig', array('formulari' => $formulari->createView(), 'equip' => $equip));
}

#[Route('/equip/nou', name:'nou_equip')]
public function nou(Request $request, ManagerRegistry $doctrine) {

    $equip = new Equip();
        $formulari = $this->createFormBuilder($equip)
            ->add('nom', TextType::class)
            ->add('cicle', TextType::class)
            ->add('curs', TextType::class)
            ->add('imatge', FileType::class,array('required' => false))
            ->add('nota', NumberType::class)
            ->add('save', SubmitType::class, array('label' => 'Enviar'))
            ->getForm();

        $formulari->handleRequest($request);

        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $equip = $formulari->getData();

            $imatge = $formulari->get('imatge')->getData();

            //$imatge = $equip->getImatge();
            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/equips/";
                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('nou_equip.html.twig', array('equip' => $equip, 'error' => $e->getMessage()));
                }
                $equip->setImatge($nomFitxer);
            } else {
                $equip->setImatge('simpsons.png');
            }

            $equip->setNom($formulari->get('nom')->getData());
            $equip->setCicle($formulari->get('cicle')->getData());
            $equip->setCurs($formulari->get('curs')->getData());
            $equip->setNota($formulari->get('nota')->getData());

            $entityManager = $doctrine->getManager();
            $entityManager->persist($equip);
            $entityManager->flush();

            return $this->redirectToRoute('inici');
        }
        return $this->render('nou_equip.html.twig', array('formulari' => $formulari->createView()));

}

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