<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    /**
     * @Route("/classe", name="classe")
     */
    public function index(ClasseRepository $classeRepository, SessionInterface $sessionInterface)
    {
        $classe=$classeRepository->findAll();
        return $this->render('classe/index.html.twig', [
            'listeclasse'=>$classe,
        ]);
    }

     /**
     * ajout de nouveau classe
     *@Route("/classe/ajout", name="ajout_classe")
     * @return response
     */
    public function ajoutclasse(ClasseRepository $classeRepository, Request $request, EntityManagerInterface $manager){
        $classe = new Classe();
        $form=$this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($classe);
            $manager->flush();
             //permet de notifier l'utilisateur
             $this->addFlash(
                'success',
                "La nouvelle classe <strong>{$classe->getId()}</strong> a bien été enregistrée"
            );
            return $this->redirectToRoute('classe');
        }

        return $this->render('classe/ajoutclass.html.twig',[
            'form'=>$form->createView()

        ]);

    }
     /**
     * Modifier un matière
     * @Route("classe/classe_modif/{id}", name="modif_classe")
     * @return Response
     */

    public function matiere_modif($id,ClasseRepository $classeRepository, Request $request, EntityManagerInterface $entityManagerInterface){
        $classe = $classeRepository->find($id);

        if(!$classe){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }
        $form=$this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($classe);
            $entityManagerInterface->flush();

            $this->addFlash(
                'success',
                "Classe <strong>{$classe->getId()}</strong> a bien été modifiée"
            );

             //permet de rediriger vers la liste des enseignants 
             return $this->redirectToRoute('classe');

        }
        return $this->render('classe/ajoutclass.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    
    /**
     * Supprimer une matière
     * @Route("/matiere/delete_classe/{id}", name="delete_classe")
     * @return Resoponse
     */
    public function delete_matiere(ClasseRepository $classeRepository, Request $request, EntityManagerInterface $manager, $id){
        $classe= $classeRepository->find($id);
        if(!$classe){
            throw $this->createNotFoundException("Identifian n'existe pas".$id);

        }


        $manager->remove($classe);
        $manager->flush();
        
          //permet de notifier l'utilisateur
          $this->addFlash(
            'success',
            "Matière <strong>{$classe->getId()}</strong> a bien été supprimée"
        );

        return $this->redirect($this->generateUrl('classe'));
    }

}
