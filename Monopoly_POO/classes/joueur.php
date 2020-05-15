<?php

class Joueur
{
  public $nomJoueur;
  public $villeJoueur = [];
  public $argent;
  public $carteJoueur = [];
  public $double = 0;

  public function __construct($nomJoueur, $villeJoueur, $argent, $carteJoueur)
  {
    $this->nomJoueur = $nomJoueur;
    $this->villeJoueur = $villeJoueur;
    $this->argent = $argent;
    $this->carteJoueur = $carteJoueur;
  }

//Permet d'obtenir un chiffre au hasard entre 1 et 6 sur 2 lancés
  public function lancerDe() {
    $de1 = rand(1, 6);
    $de2 = rand(1, 6);
    if ($de1 == $de2) {
      $this->double ++
      echo "Rejouez";
      if ($this->double == 3) {
        echo "3 doubles lancés : allez directement en prison.";
      }
    }
    else {
      echo "Avancez de " . ($de1 + $de2) . " cases.";
      $this->double = 0;
    }
  }

//Permet à un joueur de posséder une ville
  public function achatVille($ville) {
    //Verifier l'appartenance et les fonds nécessaires
    if ($ville->statut==0 && $this->argent>=$ville->prixAchat) {
      $this->argent -= $ville->prixAchat; //Retire l'argent requis
      $this->villeJoueur[$ville->couleurGrp][] = $ville; //Stock la ville
      $ville->statut = 1; //Change le statut de disponibilité de la ville
    }
    elseif ($ville->statut==0 && $this->argent<$ville->prixAchat) {
      echo ($this->nomJoueur . "Vous n'avez pas assez d'argent.");
    }
    else {
      echo "Cette ville appartient déja à un joueur";
    }
  }

//Permet a un joueur d'hypothequer une de ses villes
  public function hypotheque($ville) {
    //Verifier l'appartenance et que la ville n'a pas été deja hypothequée
    if (in_array($ville, $this->villeJoueur) && $ville->hypotheque==0) {
      $this->argent += $ville->prixVente; //Le joueur gagne l'argent de l'hypotheque
      $ville->hypotheque = 1; //La ville est indiquée comme hypothquée
    }
    elseif (in_array($ville, $this->villeJoueur) && $ville->hypotheque==1) {
      echo "Cette ville est déja hypothéquée.";
    }
    else {
      echo "Cette ville ne vous appartient pas.";
    }
  }

//Permet a un joueur de payer/recevoir un loyer
  public function loyer($ville, $joueur) {
    //Si la ville est deja à quelqu'un
    if ($ville->statut==1) {
      if (in_array($ville, $this->villeJoueur)) { //Verifier si elle appartient au joueur actif
        echo "Cette ville vous appartient.";
      }
      else {
        $this->argent -= $ville->loyer; //Sinon retirer le montant duy loyer
        $joueur->argent += $ville->loyer; //Le verser au joueur propriétaire
      }
    }
    else {
      echo "Cette ville n'a pas de propriétaire.";
    }
  }

//Permet au joueur de piocher une carte
  public function piocher($carte) {
    if ($carte->pioche == 0) {
      $this->carteJoueur[] = $carte; //Le joueur stock la carte
      $carte->pioche = 1;
    }
  }


// Code groupe des villes et leur nombre pour pouvoir acheter des maisons :
  // 0 marron : 2
  // 1 bleu : 3
  // 2 rose : 3
  // 3 orange : 3
  // 4 rouge : 3
  // 5 jaune : 3
  // 6 vert : 3
  // 7 bleu : 2

//Permet a un joueur d'upgrade sa ville en maison ou hotel
  public function maison($ville) {
    //Selon la couleur, verifie que le joueur possède toutes les villes d'un meme groupe
    if (
      (count($this->villeJoueur[$ville->couleurGrp]) == 3)
      ||
      (count($this->villeJoueur[$ville->couleurGrp]) == 2 && in_array($ville->couleurGrp,[0,7])))
    {
      $min = 5;
      foreach ($this->villeJoueur[$ville->couleurGrp] as $vil) {
        if ($vil->nbMaison<$min) {
          $min = $vil->nbMaison;
        }
      }
      if ($ville->nbMaison<=$min) {
        if($ville->nbMaison == 4) {
          if ($this->argent >= $ville->prixHotel) {
            $this->argent -= $ville->prixHotel;
            $ville->nbMaison ++;
          }
          else {
            echo "Vous n'avez pas assez d'argent pour construire un hotel.";
          }
        }
        else {
          if ($this->argent >= $ville->prixMaison) {
            $this->argent -= $ville->prixMaison;
            $ville->nbMaison ++; //Le joueur stock une maison
          }
          else {
            echo "Vous n'avez pas assez d'argent pour construire une maison.";
          }
        }
      }
      elseif ($ville->nbMaison == 5) {
        echo "Vous possédez deja un hotel, vous ne pouvez plus rien construire.";
      }
      else {
        echo "Vous devez construire une maison sur la/les autre(s) ville(s) de ce groupe avant.";
      }
    }
    else {
      echo "Vous ne possédez pas toutes les villes de ce groupe.";
    }
  }

  public function venteMaison($ville) {
    if (in_array($ville, $this->villeJoueur)) {
      if ($ville->nbMaison > 0) {
        $max = 0
        foreach ($this->villeJoueur[$ville->couleurGrp] as $vil) {
          if ($vil->nbMaison>$max) {
            $max = $vil->nbMaison;
          }
        }
        if ($ville->nbMaison == 5) {
          $this->argent += ($ville->prixHotel / 2);
          $ville->nbMaison --;
        }
        else {
          $this->argent += ($ville->prixMaison / 2);
          $ville->nbMaison --;
        }
      }
      else {
        echo "Vous n'avez aucune construction à vendre sur cette ville, hypothequez.";
      }
    }
    else {
      echo "Cette ville et ses propriétées ne vous appartiennent pas.";
    }
  }


}
