<?php

namespace App\Pdf;

use TCPDF;

class ScorePdf extends TCPDF
{
  protected $annee_scol;
  protected $semestre;
  public function __construct($annee_scol = null, $semestre = null)
  {
    parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
    $this->annee_scol = $annee_scol;
    $this->semestre = $semestre;
    // Configuration du PDF
    $this->SetCreator('Laravel App');
    $this->SetAuthor('Système de Gestion');
    $this->SetSubject('État des employés');
    $this->SetKeywords('employés, état, PDF');

    // Marges
    $this->SetMargins(15, 20, 15);
    $this->SetHeaderMargin(5);
    $this->SetFooterMargin(10);
    $this->SetAutoPageBreak(true, 25);
  }

  // Header personnalisé
  public function Header()
  {
    if ($this->page == 1) {
      $titre = "Liste des etudiants(".$this->annee_scol." Semeste ".$this->semestre.")";
      $this->SetFont('helvetica', 'B', 14);
      $this->Cell(0, 0, $titre, 0, 1, 'C');
      $this->SetXY(5, 14);
      $this->SetFont('helvetica', 'B', 9);
      $this->MultiCell(10, 6, "N°", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(15, 6, "N° INSC.", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(20, 6, "Massar", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(60, 6, "Nom et Prénom", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(40, 6, "Etablissment", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(15, 6, "Classe", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(20, 6, "Moyenne", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
    }
  }

  // Footer personnalisé
  public function Footer()
  {
    $this->SetY(-15);
    // Numéro de page
    $this->SetFont('helvetica', 'I', 8);
    $this->SetTextColor(100, 100, 100);
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'C');

    // Date et heure de génération
    $this->SetX(15);
    $this->Cell(0, 10, 'Généré le ' . date('d/m/Y à H:i'), 0, 0, 'L');
  }

  // Méthode pour créer l'en-tête du tableau

  // Méthode pour ajouter une ligne de données
}
