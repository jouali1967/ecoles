<?php

namespace App\Pdf;

use TCPDF;

class FilterPdf extends TCPDF
{
  protected $annee_scol;
  protected $semestre;
  protected $superieur_a;
  protected $inferieur_a;
  public function __construct($annee_scol = null, $semestre = null, $superieur_a = null, $inferieur_a = null)
  {
    parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
    $this->annee_scol = $annee_scol;
    $this->semestre = $semestre;
    $this->superieur_a = $superieur_a;
    $this->inferieur_a = $inferieur_a;
    // Pour l'arabe
    $this->setRTL(true);
    $this->SetFont('aealarabiya', '', 12); // ou 'dejavusans' si pas de police arabe native
    $this->SetCreator('Laravel App');
    $this->SetAuthor('نظام التسيير');
    $this->SetSubject('حالة الطلاب');
    $this->SetKeywords('طلاب, حالة, PDF');

    $this->SetMargins(15, 20, 15);
    $this->SetHeaderMargin(5);
    $this->SetFooterMargin(10);
    $this->SetAutoPageBreak(true, 25);
  }

  // Header personnalisé
  public function Header()
  {
    if ($this->page == 1) {
      $titre = " الحاصلات على معدل اكبر من" . " " . $this->superieur_a . " و اصغر من" . " " . $this->inferieur_a . "دورة" . " " . $this->semestre . "موسم" . " " . $this->annee_scol;
      $this->SetFont('aealarabiya', 'B', 14);
      // Centrer le titre par rapport au tableau (largeur totale 170mm)
      $tableWidth = 10 + 80 + 40 + 40; // = 170
      $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;
      $startX = 8; // Position du tableau
      $titreX = $startX + ($tableWidth / 2);
      $this->SetXY($startX, 10); // Y=10 pour le titre
      $this->Cell($tableWidth, 0, $titre, 0, 1, 'C', 0, '', 0, false, 'T', 'C');
      $this->SetXY(8, 18); // Obligatoire pour le tableau
      $this->SetFont('aealarabiya', 'B', 9);
      $this->MultiCell(10, 6, "الرقم", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(80, 6, "الاسم والنسب", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(40, 6, "المستوى الدراسي", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(40, 6, "المعدل", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
    }
  }

  // Footer personnalisé
  public function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('aealarabiya', 'I', 8);
    $this->SetTextColor(100, 100, 100);
    $this->Cell(0, 10, 'صفحة ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'C');
    $this->SetX(15);
    $this->Cell(0, 10, 'تم الإنشاء بتاريخ ' . date('d/m/Y H:i'), 0, 0, 'L');
  }

  // Méthode pour créer l'en-tête du tableau

  // Méthode pour ajouter une ligne de données
}
