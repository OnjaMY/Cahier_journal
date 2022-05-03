<?php

namespace App\Form;

use App\Entity\Enseignant;
use Faker\Provider\ar_JO\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('UID', TextType::class,[
                'label'=>'UID',
                'attr'=>[
                    'placeholder'=>"Entrer un UID "
                ]
            ])
            ->add('nom', TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Entrer votre nom'
                ]
            ])
            ->add('prenom', TextType::class,[
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Entrer votre prénom'
                ]
            ])
            ->add('telephone', TextType::class,[
                'label'=>'Numéro téléphone',
                'attr'=>[
                    'placeholder'=>'Entrer votre numéro téléphone'
                ]
            ])
            ->add('mail', TextType::class,[
                'label'=>'Adresse smail',
                'attr'=>[
                    'placeholder'=>'Entrer votre adresse mail'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
