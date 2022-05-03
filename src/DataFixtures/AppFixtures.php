<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for($i=1; $i<=10; $i++){
            if($i<10){
                $tel="0330".$i."34567";
            }else{
                $tel="033".$i."34567";
            }

            $enseignant = new Enseignant();
            $enseignant->setUID($i)
            ->setNom("Nom$i")
            ->setPrenom("Prenom$i")
            ->setTelephone($tel)
            ->setMail("nom$i@gmail.com");

        $manager->persist($enseignant);
        }
       

        $manager->flush();
    }
}
