<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('in_array', [$this, 'in_array']),
            new TwigFunction('activiter', [$this, 'activiter']),
        ];
    }

    public function in_array($produits,$produit): bool
    {
       foreach ($produits as $key ) {
           if ($key->getId() == $produit->getId())
           {
                return true;
           } else
           {
               return false;
           }
       }

    }

    public function activiter($activiter)
    {
       foreach ($activiter as $key ) {
           if ($key->getActivitePrincipale())
           {
              if ($key->getActivitePrincipale())
                return $key->getChiffreAffaire();
                else 
                return $key->getValeurAjoutee();

           }
       }
       return "";

    }
}