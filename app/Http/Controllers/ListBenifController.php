<?php

namespace App\Http\Controllers;

use App\Pdf\BenifPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListBenifController extends Controller
{
   public function generate(Request $request){
    $annee_scol = $request->input('annee_scol');
    $etudiants = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
    ->where('etudiants.ben_part', 'oui') // boursiers
    ->where('inscriptions.annee_scol', $annee_scol) // ✅ année scolaire depuis la table inscriptions
    ->select(
        'etudiants.id as etudiant_id',
        'etudiants.nom_ar',
        'etudiants.prenom_ar',
        'etudiants.num_enr',
        'etudiants.code_massar',
        'etudiants.etud_photo',
        'etudiants.tel_pere',
        'etudiants.tel_mere',
        'classes.nom_classe',
        'classes.abr_classe',
    )
    ->orderBy('etudiants.nom_ar')
    ->get();
    $pdf = new BenifPdf($annee_scol);
    $pdf->AddPage();
    $pdf->SetY(24);
      $compteur = 1;
    $count_etud = count($etudiants);
    foreach ($etudiants as $etudiant) {
      $pdf->SetX(8);
      $pdf->SetFont('aealarabiya', '', 10); // Police arabe
      // Données
      $pdf->Cell(25, 6, $etudiant->code_massar, 1, 0, 'R', false);
      $pdf->Cell(80, 6, $etudiant->nom_ar . ' ' . $etudiant->prenom_ar, 1, 0, 'R', false); // Aligné à droite
      $pdf->Cell(40, 6, $etudiant->abr_classe, 1, 0, 'R', false);
      $pdf->Cell(40, 6, $etudiant->tel_pere ?? $etudiant->tel_mere ?? '', 1, 1, 'R', false);
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
