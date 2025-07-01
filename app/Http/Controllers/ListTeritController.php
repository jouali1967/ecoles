<?php

namespace App\Http\Controllers;

use App\Pdf\TeritPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListTeritController extends Controller
{
    public function generate(Request $request){
      $dom_ter = $request->input('dom_ter');
            $etudiants = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
    ->where('etudiants.dom_ter', $dom_ter) // boursiers
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
    $pdf = new TeritPdf($dom_ter);
    $pdf->AddPage();
    $pdf->SetY(24);
      $compteur = 1;
    $count_etud = count($etudiants);
    foreach ($etudiants as $etudiant) {
      $pdf->SetX(8);
      $pdf->SetFont('aealarabiya', '', 10); // Police arabe
      // Données
      $pdf->Cell(80, 6, $etudiant->nom_ar . ' ' . $etudiant->prenom_ar, 1, 0, 'R', false); // Aligné à droite
      $pdf->Cell(40, 6, $etudiant->abr_classe, 1, 1, 'R', false);
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
