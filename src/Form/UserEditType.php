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

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputsRoles = $options['inputRoles'];
       
        $builder->remove('username');
        $builder->remove('plainPassword');
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
            ->add('email',TextType::class,array('label'=>'Email','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('tel',TextType::class,array('label'=>'Tél','required'=>false,'attr'=>array('class'=>'form-control')))
            ->add('matricule',TextType::class,array('label'=>'Matricule','required'=>false,'attr'=>array('class'=>'form-control')))
          
            ->add('roles', ChoiceType::class, array(
                    'attr'  =>  array('class' => 'form-control',
                    'style' => 'margin:5px 0;'),
                    'choices' => $inputsRoles
                    ,
                    'multiple' => true,
                    'required' => true,
                     'expanded' => true,
                    ))


           

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
