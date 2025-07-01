<?php

namespace App\Http\Controllers;

use App\Pdf\FilterPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterScoreController extends Controller
{
  public function generate(Request $request)
  {
    $annee_scol = $request->input('annee_scol');
    $semestre = $request->input('semestre');
    $superieur_a = $request->input('superieur_a');
    $inferieur_a = $request->input('inferieur_a');
    $etudiants = DB::table('etudiants') // Assurez-vous que cette table existe
      ->Join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
      ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
      ->join('notes', function ($join) use ($annee_scol, $semestre) {
        $join->on('etudiants.id', '=', 'notes.etudiant_id')
          ->where('notes.annee_scol', $annee_scol)
          ->where('notes.semestre', $semestre);
      })
      ->select(
        'etudiants.id as etudiant_id',
        'etudiants.nom_ar',
        'etudiants.prenom_ar',
        'classes.nom_classe',
        'classes.abr_classe',
        DB::raw('SUM(notes.note_calc * notes.coefficient) as total_notes'),
        DB::raw('SUM(notes.coefficient) as total_coefficients'),
        DB::raw('SUM(notes.note_calc * notes.coefficient) / NULLIF(SUM(notes.coefficient), 0) as moyenne')
      )
      ->groupBy(
        'etudiants.id',
        'etudiants.nom_ar',
        'etudiants.prenom_ar',
        'classes.nom_classe',
        'classes.abr_classe'
      )
      ->havingRaw(
        'SUM(notes.note_calc * notes.coefficient) / NULLIF(SUM(notes.coefficient), 0) > ? 
         AND SUM(notes.note_calc * notes.coefficient) / NULLIF(SUM(notes.coefficient), 0) < ?',
        [$superieur_a, $inferieur_a]
      )
      ->orderBy('moyenne', 'desc')
      ->get();
    $pdf = new FilterPdf($annee_scol,$semestre,$superieur_a,$inferieur_a);
    $pdf->AddPage();
    $pdf->SetY(24);
        $compteur = 1;
    $count_etud = count($etudiants);
    foreach ($etudiants as $etudiant) {
      $pdf->SetX(8);
      $pdf->SetFont('aealarabiya', '', 10); // Police arabe
      // Données
      $pdf->Cell(10, 6, $compteur, 1, 0, 'C', false);
      $pdf->Cell(80, 6, $etudiant->nom_ar . ' ' . $etudiant->prenom_ar, 1, 0, 'R', false); // Aligné à droite
      $pdf->Cell(40, 6, $etudiant->abr_classe, 1, 0, 'L', false);
      $pdf->Cell(40, 6, number_format($etudiant->moyenne, 2, ',', ' '), 1, 1, 'C', false);
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
