<?php

class Carte
{
  public $nomCarte;
  public $effet;
  public $pioche = 0;

  public function __construct($nomCarte, $effet)
  {
    $this->nomCarte = $nomCarte;
    $this->effet = $effet;
  }
}
