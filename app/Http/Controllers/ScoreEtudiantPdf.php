<?php

namespace App\Http\Controllers;

use App\Pdf\ScorePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreEtudiantPdf extends Controller
{
    public function generate(Request $request){
      $annee_scol = $request->input('annee_scol');
      $semestre = $request->input('semestre');

      $etudiants = DB::table('etudiants') // Assurez-vous que cette table existe
        ->Join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
        ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
        ->join('notes', function ($join) use ($annee_scol, $semestre) {
          $join->on('etudiants.id', '=', 'notes.etudiant_id')
            ->where('notes.annee_scol', $annee_scol)
            ->where('notes.semestre', $semestre);
        })
        ->select(
'etudiants.id',
          'etudiants.num_enr',
          'etudiants.nom',
          'etudiants.prenom',
          'etudiants.code_massar',
          'etudiants.etud_photo',
          'etudiants.niv_scol',
          'classes.nom_classe',
          'classes.abr_classe',
          DB::raw('SUM(notes.note_calc * notes.coefficient) as total_notes'),
          DB::raw('SUM(notes.coefficient) as total_coefficients'),
          DB::raw('SUM(notes.note_calc * notes.coefficient) / NULLIF(SUM(notes.coefficient), 0) as moyenne')
        )
        ->groupBy(
  'etudiants.id',
          'etudiants.num_enr',
          'etudiants.nom',
          'etudiants.prenom',
          'etudiants.code_massar',
          'etudiants.etud_photo',
          'etudiants.niv_scol',
          'classes.nom_classe',
          'classes.abr_classe'
        )
        ->orderBy('moyenne', 'desc')
        ->get();
    $pdf = new ScorePdf($annee_scol,$semestre);
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
      $pdf->Cell(40, 6, $etudiant->niv_scol, 1, 0, 'L', false);
      $pdf->Cell(15, 6, $etudiant->abr_classe, 1, 0, 'L', false);
      $pdf->Cell(20, 6, number_format($etudiant->moyenne, 2, ',', ' '), 1, 1, 'C', false);
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
