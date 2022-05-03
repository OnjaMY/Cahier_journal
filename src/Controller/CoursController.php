<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index(CoursRepository $coursRepository, SessionInterface $sessionInterface)
    {
        $cours=$coursRepository->findAll();
        return $this->render('cours/index.html.twig', [
            'course'=>$cours
        ]);
    }

    /**
     * ajout de nouveau cours
     *@Route("/cours/ajout", name="ajout_cours")
     * @return response
     */
    public function ajoutmatiere(CoursRepository $coursRepository, Request $request, EntityManagerInterface $manager){
        $cours = new Cours();
        $form=$this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($cours);
            $manager->flush();
             //permet de notifier l'utilisateur
             $this->addFlash(
                'success',
                "Le nouveau cours <strong>{$cours->getId()}</strong> a bien été enregistrée"
            );
            return $this->redirectToRoute('cours');
        }

        return $this->render('cours/ajout.html.twig',[
            'form'=>$form->createView()

        ]);

    }

     /**
     * Modifier un Cours
     * @Route("cours/cours_modif/{id}", name="modif_cours")
     * @return Response
     */

    public function cours_modif($id,CoursRepository $coursRepository, Request $request, EntityManagerInterface $entityManagerInterface){
        $cours= $coursRepository->find($id);

        if(!$cours){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }
        $form=$this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($cours);
            $entityManagerInterface->flush();

            $this->addFlash(
                'success',
                "Cours <strong>{$cours->getId()}</strong> a bien été modifiée"
            );

             //permet de rediriger vers la liste des enseignants 
             return $this->redirectToRoute('cours');

        }
        return $this->render('cours/ajout.html.twig',[
            'form'=>$form->createView()
        ]);
    }

   
    /**
     * Supprimer un  niveau   
     * @Route("/cours/delete_cours/{id}", name="delete_cours")
     * @return Response
     */
    public function delete_cours(CoursRepository $coursRepository, Request $request, EntityManagerInterface $manager, $id){
        $cours= $coursRepository->find($id);
        if(!$cours){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }


        $manager->remove($cours);
        $manager->flush();
        
          //permet de notifier l'utilisateur
          $this->addFlash(
            'success',
            "Cours <strong>{$cours->getId()}</strong> a bien été supprimée"
        );

        return $this->redirect($this->generateUrl('cours'));
    }
}
