<?php

namespace App\Form;

use App\Entity\NiNineaproposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiNineaproposition1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ninid')
            ->add('ninLocalite')
            ->add('ninVille')
            ->add('ninTelephon')
            ->add('ninBoitpost')
            ->add('ninadresse')
            ->add('ninAdresse')
            ->add('ninVoie')
            ->add('ninNvoie')
            ->add('ninType')
            ->add('ninRaison')
            ->add('ninSexe')
            ->add('ninRegcom')
            ->add('ninStatut')
            ->add('ninNumattrib')
            ->add('ninIdsuff')
            ->add('ninNinea')
            ->add('ninMisajour')
            ->add('ninRegime')
            ->add('ninSecteur')
            ->add('ninPers')
            ->add('ninActivite')
            ->add('ninSigle')
            ->add('ninAffaires')
            ->add('ninAnnee_ca')
            ->add('ninCapital')
            ->add('ninEffect1')
            ->add('ninEffectif')
            ->add('ninEffectiffem')
            ->add('ninEffectiffemsais')
            ->add('ninAutact')
            ->add('ninAutact1')
            ->add('ninAutact2')
            ->add('ninCessation')
            ->add('ninCivil')
            ->add('ninCodop')
            ->add('ninCompid')
            ->add('ninControle')
            ->add('ninCreation')
            ->add('ninCsf')
            ->add('ninCuci')
            ->add('ninDatecre')
            ->add('ninDatcre')
            ->add('ninDatNais')
            ->add('ninDatreg')
            ->add('ninEmail')
            ->add('ninEmploy')
            ->add('ninEnseigne')
            ->add('ninEtabSecond')
            ->add('ninEtabt')
            ->add('ninEtat')
            ->add('ninForme')
            ->add('ninImposition')
            ->add('ninInterieu')
            ->add('ninLieu')
            ->add('ninLieunais')
            ->add('ninMatri')
            ->add('ninMode')
            ->add('ninNational')
            ->add('ninNature')
            ->add('ninNatures')
            ->add('ninNbetab')
            ->add('ninNiden')
            ->add('ninNineamere')
            ->add('ninNommari')
            ->add('ninNumcss')
            ->add('ninNumetab')
            ->add('ninNumimpot')
            ->add('ninNumipres')
            ->add('ninOcc')
            ->add('ninOrigine')
            ->add('ninPatente')
            ->add('ninPerception')
            ->add('ninPrspro')
            ->add('ninAutorisation')
            ->add('ninX')
            ->add('ninM')
            ->add('ninRsad')
            ->add('ninnineacss')
            ->add('ninnineaipres')
            ->add('ninnineadgd')
            ->add('ninppm')
            ->add('ninagancess')
            ->add('ninactivitecss')
            ->add('ninsiglemere')
            ->add('ninlocalitedgid')
            ->add('ninmajdate')
            ->add('ninconsolide')
            ->add('ninconsolidedate')
            ->add('ninformejuridique')
            ->add('ninCni')
            ->add('ninPrenom')
            ->add('ninNom')
            ->add('ninnumerodemande')
            ->add('ninAdministration')
            ->add('ninestNouveau')
            ->add('nintransmis')
            ->add('nincreationninea')
            ->add('ninvalidercodi')
            ->add('ninutilisation')
            ->add('ninadressedomicile')
            ->add('ninnompresidentgiesociete')
            ->add('ninuserencours')
            ->add('nindatecni')
            ->add('nindatesuspension')
            ->add('nindatereprise')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiNineaproposition::class,
        ]);
    }
}
