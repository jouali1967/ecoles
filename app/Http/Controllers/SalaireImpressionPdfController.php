<?php

namespace App\Http\Controllers;

use App\Pdf\SalairePdf;
use Illuminate\Http\Request;
use App\Models\Salaire;
use Elibyy\TCPDF\Facades\TCPDF;

class SalaireImpressionPdfController extends Controller
{
  public function export(Request $request)
  {
    $mois = $request->input('mois');
    $annee = $request->input('annee');
    $salaires = Salaire::with('personne')
      ->whereMonth('date_virement', $mois)
      ->whereYear('date_virement', $annee)
      ->get();

    $pdf = new SalairePdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->AddPage();

    // Titre
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 8, 'Période : ' . str_pad($mois, 2, '0', STR_PAD_LEFT) . '/' . $annee, 0, 1, 'L');
    $pdf->SetLineWidth(1); // Définir l'épaisseur de la ligne
    $pdf->line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->SetLineWidth(0.2); // Réinitialiser l'épaisseur de la ligne pour les autres éléments
    $pdf->Ln(2);

    // En-tête du tableau avec fond de couleur et centrage vertical
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetFillColor(220, 220, 220); // gris clair
    $pdf->MultiCell(60, 8, "Nom et Prénom", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 8, "Salaire de\nBase", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 8, "Montant\nPrimes", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 8, "Montant\nSanctions", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 8, "Salaire\nMensuel", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
    $pdf->MultiCell(40, 8, "N° Compte", 1, 'C', 1, 1, null, null, true, 0, false, true, 8, 'M');

    // Lignes du tableau avec centrage vertical
    $pdf->SetFont('helvetica', '', 8);
    foreach ($salaires as $salaire) {
      $pdf->MultiCell(60, 5, $salaire->personne->nom . ' ' . $salaire->personne->prenom, 1, 'L', 0, 0, null, null, true, 0, false, true, 0, 'M');
      $pdf->MultiCell(20, 5, $salaire->salaire_base, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_prime, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_sanction, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_vire, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(40, 5, $salaire->personne->num_compte, 1, 'R', 0, 1, null, null, true, 0, false, true, 5, 'M');
    }

    $pdf->Output('etat_salaires.pdf');
  }
  public function exporttest()
  {

    $personnes = [
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'jouali gharib',
        'date_nais' => '12/09/1987',
        'obs' => 45
      ],
      [
        'name' => 'montassir aderrahim',
        'date_nais' => '12/09/1988',
        'obs' => 20
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba mohammed',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba test',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba test',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba bbbbb',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba cccccc',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba dddd',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
      [
        'name' => 'baba eeee',
        'date_nais' => '12/09/1987',
        'obs' => 60
      ],
    ];
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setMargins(5, 10, 5);
    $pdf->AddPage();
    $pdf->Cell(0, 0, "jouali", 0, 1, 'C');
    $pdf->Cell(70, 5, "Email:joualighar@gmail.com", 0, 0, '');
    $pdf->Cell(60, 5, "Adresse:Rue 12 Salaaljadida", 0, 0, '');
    $pdf->Cell(60, 5, "N°Telephone:676765454", 0, 1, '');
    $pdf->ln(2);
    $pdf->Cell(10, 7, "Id", 1, 0, 'L');
    $pdf->Cell(50, 7, "Nom et Pranom", 1, 0, 'L');
    $pdf->Cell(40, 7, "Date De Naissance", 1, 0, 'L');
    $pdf->Cell(40, 7, "obbbbbb", 1, 1, 'L');
    $tot = 0;
    $count = 0;
    foreach ($personnes as $personne) {
      // On calcule l'espace nécessaire pour le total et les signatures (environ 70mm)
      $espaceNecessaire = 59;

      // Vérification de l'espace restant sur la page
      // if ($pdf->getPageHeight() - $pdf->getBreakMargin() - $pdf->GetY() < ($espaceNecessaire + 5)) {
      //     $pdf->AddPage();
      //     $count=0;
      // }
      
      if ($pdf->getPageHeight() - $pdf->getBreakMargin() - $pdf->GetY() < ($espaceNecessaire + 6)) {
        if ($pdf->getAliasNbPages() < $pdf->getPage()) {
          $pdf->AddPage(); 
          $count = 0;
        }
      }
      $count++;
      $pdf->Cell(10, 6, $count, 1, 0, 'L');
      $pdf->Cell(50, 6, $personne['name'], 1, 0, 'L');
      $pdf->Cell(40, 6, $personne['date_naissance'] ?? '', 1, 0, 'L');
      $pdf->Cell(40, 6, $personne['observation'] ?? '', 1, 1, 'L');

      // Accumulation du total si 'obs' existe
      $tot += isset($personne['obs']) ? $personne['obs'] : 0;
    }

    // Total (sans saut de page)
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(90, 7, 'Total', 1, 0, 'R');
    $pdf->Cell(40, 7, number_format($tot, 2, '.', ' '), 1, 1, 'R');

    // Espacement réduit
    $pdf->Ln(5);

    // Section des signatures
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(90, 10, 'Le Trésorier', 1, 'L', false, 0);
    $pdf->MultiCell(90, 10, 'Chef de service', 1, 'L', false, 1);
    $pdf->MultiCell(90, 40, '', 1, 'L', false, 0);
    $pdf->Output('etat_test.pdf');
  }
}
