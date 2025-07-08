<?php

namespace App\Pdf;

use TCPDF;

class HandicapPdf extends TCPDF
{
  protected $dom_ter;
  public function __construct($dom_ter = null)
  {
    parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
    $this->dom_ter = $dom_ter;
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
      $titre = "لائحة ذوي الاحتياجات الخاصة" ;
      $this->SetFont('aealarabiya', 'B', 14);
      // Centrer le titre par rapport au tableau (largeur totale 170mm)
      $tableWidth = 80 + 40 +40 ; // = 120
      $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;
      $startX = 8; // Position du tableau
      $titreX = $startX + ($tableWidth / 2);
      $this->SetXY($startX, 10); // Y=10 pour le titre
      $this->Cell($tableWidth, 0, $titre, 0, 1, 'C', 0, '', 0, false, 'T', 'C');
      $this->SetXY(8, 18); // Obligatoire pour le tableau
      $this->SetFont('aealarabiya', 'B', 9);
      $this->MultiCell(80, 6, "الاسم والنسب", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(40, 6, "المستوى الدراسي", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
      $this->MultiCell(40, 6, "نوع الاعاقة", 1, 'C', 0, 0, null, null, true, 0, false, true, 6, 'M');
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
