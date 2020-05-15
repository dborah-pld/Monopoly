<?php

class Ville
{
  public $nomVille;
  public $prixAchat;
  public $loyer;
  public $prixVente;
  public $statut = 0;
  public $hypotheque = 0;
  public $couleurGrp;
  public $prixMaison;
  public $prixHotel;
  public $nbMaison = 0;

  public function __construct($nomVille, $prixAchat, $loyer, $prixVente, $couleurGrp, $prixMaison, $prixHotel)
  {
    $this->nomVille = $nomVille;
    $this->prixAchat = $prixAchat;
    $this->loyer = $loyer;
    $this->prixVente = $prixVente;
    $this->couleurGrp = $couleurGrp;
    $this->prixMaison = $prixMaison;
    $this->prixHotel = $prixHotel;
  }
}
