<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Pdf\EtatEtudiantPdf;
use Illuminate\Http\Request;

class EtudiantPdf extends Controller
{
  public function generate(Request $request)
  {
    $annee_insc = $request->input('annee_insc');
    $scol_lib = $request->input('scol_lib');
    $etudiants = Etudiant::query()
      ->whereHas('lastInscription')
      ->with(['lastInscription.classe'])
      ->when($annee_insc, function ($query) use (&$titre_an, $annee_insc) {
        //$titre_an='incsrits en '.$annee_insc;
        $query->whereYear('date_insc', $annee_insc);
      })
      ->when($scol_lib, function ($query) use (&$titre_niv, $scol_lib) {
        //$titre_niv=$scol_lib;  
        $query->where('niv_scol', $scol_lib);
      })
      ->get();

    $pdf = new EtatEtudiantPdf($annee_insc,$scol_lib);
    $pdf->AddPage();
    $pdf->SetY(20);

    $compteur = 1;
    $count_etud = count($etudiants);
    foreach ($etudiants as $etudiant) {
      $pdf->SetX(5);
      $pdf->SetFont('helvetica', '', 8);
      // Données
      $pdf->Cell(10, 6, $compteur, 1, 0, 'C', false);
      $pdf->Cell(15, 6, $etudiant->num_enr, 1, 0, 'C', false);
      $pdf->Cell(20, 6, $etudiant->code_massar, 1, 0, 'C', false);
      $pdf->Cell(60, 6, mb_strtoupper($etudiant->nom . ' ' . $etudiant->prenom, 'UTF-8'), 1, 0, 'L', false);
      $pdf->Cell(40, 6, $etudiant->niv_scol ?: '-', 1, 0, 'L', false);
      $pdf->Cell(15, 6, optional($etudiant->lastInscription->classe)->abr_classe ?? '-', 1, 0, 'L', false);
      $pdf->Cell(20, 6, $etudiant->date_insc ?: '-', 1, 1, 'C', false);
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
