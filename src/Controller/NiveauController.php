<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NiveauController extends AbstractController
{
    /**
     * @Route("/niveau", name="niveau")
     */
    public function index(NiveauRepository $niveauRepository, SessionInterface $sessionInterface)
    {
        $niveau=$niveauRepository->findAll();
        return $this->render('niveau/index.html.twig', [
            'niveaux'=>$niveau,
        ]);
    }
     /**
     * ajout de nouveau niveau
     *@Route("/niveau/ajout", name="ajout_niveau")
     * @return response
     */
    public function ajoutmatiere(NiveauRepository $matiereRepository, Request $request, EntityManagerInterface $manager){
        $niveau = new Niveau();
        $form=$this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($niveau);
            $manager->flush();
             //permet de notifier l'utilisateur
             $this->addFlash(
                'success',
                "Le nouveau matière <strong>{$niveau->getId()}</strong> a bien été enregistrée"
            );
            return $this->redirectToRoute('niveau');
        }

        return $this->render('niveau/ajout.html.twig',[
            'form'=>$form->createView()

        ]);

    }
     /**
     * Modifier un niveau
     * @Route("niveau/niveau_modif/{id}", name="modif_niveau")
     * @return Response
     */

    public function niveau_modif($id,NiveauRepository $niveauRepository, Request $request, EntityManagerInterface $entityManagerInterface){
        $niveau= $niveauRepository->find($id);

        if(!$niveau){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }
        $form=$this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($niveau);
            $entityManagerInterface->flush();

            $this->addFlash(
                'success',
                "Matière <strong>{$niveau->getId()}</strong> a bien été modifiée"
            );

             //permet de rediriger vers la liste des enseignants 
             return $this->redirectToRoute('niveau');

        }
        return $this->render('niveau/ajout.html.twig',[
            'form'=>$form->createView()
        ]);
    }

   
    /**
     * Supprimer un  niveau   
     * @Route("/niveau/delete_niveau/{id}", name="delete_niveau")
     * @return Response
     */
    public function delete_matiere(NIveauRepository $niveauRepository, Request $request, EntityManagerInterface $manager, $id){
        $niveau= $niveauRepository->find($id);
        if(!$niveau){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }


        $manager->remove($niveau);
        $manager->flush();
        
          //permet de notifier l'utilisateur
          $this->addFlash(
            'success',
            "Niveau <strong>{$niveau->getId()}</strong> a bien été supprimée"
        );

        return $this->redirect($this->generateUrl('niveau'));
    }
}
