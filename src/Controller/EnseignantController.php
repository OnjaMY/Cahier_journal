<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="enseignant")
     */
    public function index(EnseignantRepository $enseignantRepository, SessionInterface $sessionInterface)
    {
        $enseignant=$enseignantRepository->findAll();
        return $this->render('enseignant/index.html.twig', [
                'listenseignants'=>$enseignant,
        ]);
    }

    /**
     * Permet de créer une annonce
     *@Route("/enseignant/new", name="enseignant_create")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, EnseignantRepository $enseignantRepository, SessionInterface $sessionInterface){
       
        $enseignant = new Enseignant();
        $form=$this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

       
        // $this->addFlash(
        //     'success',
        //     "Deuxième flash"
        // );
        // $this->addFlash(
        //     'danger',
        //     "Message d'erreur"
        // );
        //dump($enseignant);
        if($form->isSubmitted() && $form->isValid()){
          //  $manager=$this->getDoctrine()->getManager(); on a ajouter manager dans le paramètre
          //permet de sauver les données
            $manager->persist($enseignant);
            //permet d'envoyer les données dans la base de données
            $manager->flush();

            //permet de notifier l'utilisateur
            $this->addFlash(
                'success',
                "Enseignant enregistré <strong>{$enseignant->getId()}</strong> a bien été enregistrée"
            );

            //permet de rediriger vers la liste des enseignants 
            return $this->redirectToRoute('enseignant');
        }

        $enseignant=$enseignantRepository->findAll();
        return $this->render('enseignant/new.html.twig',[
            'form'=>$form->createView(),
            'listenseignants'=>$enseignant,
          //  'editMode'=>$enseignant[]->getId() !== null
        ]);

    }


    /**
     * Permet de modifier un enseignant
     * @Route("/edit_enseignant/{id}", name="modif_enseignant")
     * @return Response
     */

    function Modif_enseignant(EnseignantRepository $repo, Request $request, EntityManagerInterface $manager, $id){

        $enseignant= $repo->find($id);

        //si id existe
        if(!$enseignant){
            throw $this->createNotFoundException("Identifiant n'existe pas".$id) ;
        }

        $form=$this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //  $manager=$this->getDoctrine()->getManager(); on a ajouter manager dans le paramètre
            //permet de sauver les données
              $manager->persist($enseignant);
              //permet d'envoyer les données dans la base de données
              $manager->flush();

                //permet de notifier l'utilisateur
            $this->addFlash(
                'success',
                "Enseignant <strong>{$enseignant->getId()}</strong> a bien été modifiée"
            );
  
              //permet de rediriger vers la liste des enseignants 
              return $this->redirectToRoute('enseignant_create');
          }
        return $this->render('enseignant/new.html.twig',[
            'form'=>$form->createView(),
            'listenseignants'=>$enseignant,
            'editMode'=>$enseignant->getId() !== null
        ]);
    }

    /**
     * permet de supprimer un enseignant
     *@Route("/delete_enseignant/{id}", name="delete_enseignant")
     * @return Response
     */
    public function delete_enseignat(EnseignantRepository $repo, Request $request, EntityManagerInterface $manager, $id){
        $enseignant= $repo->find($id);

        //si id existe
        if(!$enseignant){
            throw $this->createNotFoundException("Identifiant n'existe pas".$id) ;
        }

        $manager->remove($enseignant);
        $manager->flush();
        
          //permet de notifier l'utilisateur
          $this->addFlash(
            'success',
            "Enseignant <strong>{$enseignant->getId()}</strong> a bien été supprimée"
        );

        return $this->redirect($this->generateUrl('enseignant_create'));

    }
}
