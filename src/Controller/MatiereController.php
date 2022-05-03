<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatiereController extends AbstractController
{
    /**
     * @Route("/matiere", name="matiere")
     */
    public function index(MatiereRepository $matiereRepository, SessionInterface $session)
    {
        $matiere = $matiereRepository->findAll();
        return $this->render('matiere/index.html.twig', [
            'matieres' => $matiere
        ]);
    }

    /**
     * ajout de nouveau ùmatière
     *@Route("/matiere/ajout", name="ajout_matiere")
     * @return response
     */
    public function ajoutmatiere(MatiereRepository $matiereRepository, Request $request, EntityManagerInterface $manager){
        $matiere = new Matiere();
        $form=$this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($matiere);
            $manager->flush();
             //permet de notifier l'utilisateur
             $this->addFlash(
                'success',
                "Le nouveau matière <strong>{$matiere->getId()}</strong> a bien été enregistrée"
            );
            return $this->redirectToRoute('matiere');
        }

        return $this->render('matiere/ajoutclasse.html.twig',[
            'form'=>$form->createView()

        ]);

    }
    
    /**
     * Modifier un matière
     * @Route("matiere/matiere_modif/{id}", name="modif_matiere")
     * @return Response
     */

    public function matiere_modif($id,MatiereRepository $matiereRepository, Request $request, EntityManagerInterface $entityManagerInterface){
        $matiere= $matiereRepository->find($id);

        if(!$matiere){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }
        $form=$this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($matiere);
            $entityManagerInterface->flush();

            $this->addFlash(
                'success',
                "Matière <strong>{$matiere->getId()}</strong> a bien été modifiée"
            );

             //permet de rediriger vers la liste des enseignants 
             return $this->redirectToRoute('matiere');

        }
        return $this->render('matiere/ajout.html.twig',[
            'form'=>$form->createView()
        ]);
    }

   
    /**
     * Supprimer une matière    
     * @Route("/matiere/delete_matiere/{id}", name="delete_matiere")
     * @return Resoponse
     */
    public function delete_matiere(MatiereRepository $matiereRepository, Request $request, EntityManagerInterface $manager, $id){
        $matiere= $matiereRepository->find($id);
        if(!$matiere){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }


        $manager->remove($matiere);
        $manager->flush();
        
          //permet de notifier l'utilisateur
          $this->addFlash(
            'success',
            "Matière <strong>{$matiere->getId()}</strong> a bien été supprimée"
        );

        return $this->redirect($this->generateUrl('matiere'));
    }
}
