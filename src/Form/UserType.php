<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputsRoles = $options['inputRoles'];
        
        $builder
             ->add('prenom',TextType::class,
                   array('label'=>'Prénom ',
                          'required'=>true,
                          'attr'=>array('class'=>'form-control'),
                          'constraints' => [
                            new NotBlank([
                                'message' => 'Le prénom est obligatoir'
                                ])]
                ))
            ->add('nom',TextType::class,
                   array('label'=>'Nom',
                         'required'=>true,
                         'attr'=>array('class'=>'form-control'),
                         'constraints' => [
                            new NotBlank([
                                'message' => 'Le nom est obligatoir',
                                ])]

                     ))
             ->add('dateExpiration', DateType::class, ['label'=>'Date d\'expiration',
                'attr'=>array('class'=>'form-control'),
                'required'=>true,
                'widget' => 'single_text'])

            ->add('dateNaissance', DateType::class, ['label'=>'Date Naissance',
                'attr'=>array('class'=>'form-control' ,'id'=>"example-date-input"),
                'required'=>false,
                'widget' => 'single_text'])
            ->add('LieuNaissance',TextType::class,array('label'=>'Lieu Naissance','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('sexe',ChoiceType::class, ['required'=>false,'attr'=>array('class'=>'form-select', 'placeholder'=>'Choisissez le sexe'),'label'=>'Sexe','choices' => ['Choisissez le sexe'=>'','M'=>'M','F'=>'F']])
            ->add('email',TextType::class,array('label'=>'Email','required'=>true,'attr'=>array('class'=>'form-control',"type"=>"email")))
            ->add('tel',TextType::class,array('label'=>'Téléphone','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('description',TextareaType::class,array('label'=>'Description','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('matricule',TextType::class,array('label'=>'Matricule','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('username',TextType::class,
                   array('label'=>'Nom d\'utilisateur ' ,
                         'required'=>true,
                         'attr'=>array('class'=>'form-control'),
                         'constraints' => [
                            new NotBlank([
                                'message' => 'Le prénom est obligatoir',
                                ])]

                     ))

            ->add('roles', ChoiceType::class, array(
                    'attr'  =>  array('class' => 'form-control',
                    'style' => 'margin:5px 0;'),
                    'choices' => $inputsRoles ,
                    'multiple' => true,
                    'required' => true,
                     'expanded' => true,
                    ))


             ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                 'type' => PasswordType::class,
                'attr' => ['class' => 'form-control','autocomplete' => 'new-password'],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer '],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('inputRoles');
        
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
