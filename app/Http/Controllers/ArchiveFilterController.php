<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Pdf\ArchiveFilterPdf;
use Illuminate\Http\Request;

class ArchiveFilterController extends Controller
{
  public function generate(Request $request)
  {
    $annee_scol = $request->input('annee_scol');
    $sup_a = $request->input('sup_a');
    $inf_a = $request->input('inf_a');

    $archives = Archive::with(['etudiant.lastInscription.classe'])
      ->selectRaw('etudiant_id, annee_scol,
                  MAX(CASE WHEN semestre = 1 THEN moyenne END) as moy_s1,
                  MAX(CASE WHEN semestre = 2 THEN moyenne END) as moy_s2,
                  AVG(moyenne) as moyenne_annuelle')
      ->where('annee_scol', $annee_scol)
      ->groupBy('etudiant_id', 'annee_scol')
      ->when(
        is_numeric($sup_a) && $sup_a !== '',
        function ($query) use ($sup_a) {
          $query->havingRaw('AVG(moyenne) > ?', [$sup_a]);
        }
      )
      ->when(
        is_numeric($inf_a) && $inf_a !== '',
        function ($query) use ($inf_a) {
          $query->havingRaw('AVG(moyenne) < ?', [$inf_a]);
        }
      )
      ->get();
    $pdf = new ArchiveFilterPdf($annee_scol,  $sup_a, $inf_a);
    $pdf->AddPage();
    $pdf->SetY(24);
    $compteur = 1;
    $count_etud = count($archives);
    foreach ($archives as $item) {
      $pdf->SetX(8);
      $pdf->SetFont('aealarabiya', '', 10); // Police arabe
      // Données
      $pdf->Cell(10, 6, $compteur, 1, 0, 'C', false);
      $pdf->Cell(80, 6, $item->etudiant->nom_ar . ' ' . $item->etudiant->prenom_ar, 1, 0, 'R', false); // Aligné à droite
      $pdf->Cell(40, 6, $item->etudiant->lastInscription->classe->abr_classe, 1, 0, 'L', false);
      $pdf->Cell(40, 6,  number_format($item->moyenne_annuelle, 2), 1, 1, 'C', false);
      $compteur++;
      $count_etud = $count_etud - 1;
      if ($pdf->GetY() + 45 > ($pdf->getPageHeight() - $pdf->getFooterMargin()) and $count_etud < 5) {
        $pdf->AddPage();
      }
    }

    // Génération du PDF
    return $pdf->Output('etat_etudiants_' . date('Y-m-d') . '.pdf', 'I');
  }
}
