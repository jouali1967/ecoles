<?php

namespace App\Pdf;

use TCPDF;

class CustomPdf extends TCPDF
{
    // Header personnalisé
    public function Header()
    {
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->SetXY(4,6);
        $this->Cell(0, 15, 'Liste des Primes', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // Line break
        $this->Ln();
        // You can add more header elements here if needed
    }

    // Footer personnalisé
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}
