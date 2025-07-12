<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Pdf\OrphelinPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrphelinPdfController extends Controller
{
  public function generate(Request $request)
  {
    /*$latestInscriptions = DB::table('inscriptions')
      ->select('etudiant_id', DB::raw('MAX(annee_scol) as max_annee'))
      ->groupBy('etudiant_id');

    $etudiants = DB::table('etudiants')
      ->joinSub($latestInscriptions, 'latest_inscriptions', function ($join) {
        $join->on('etudiants.id', '=', 'latest_inscriptions.etudiant_id');
      })
      ->join('inscriptions', function ($join) {
        $join->on('etudiants.id', '=', 'inscriptions.etudiant_id')
          ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
      })
      ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
      ->where('etudiants.orphelin', 'oui')
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
        'classes.abr_classe'
      )
      ->orderBy('etudiants.nom_ar')
      ->get();*/
    $etudiants = Etudiant::with('lastInscription.classe')
                  ->where('etudiants.orphelin', 'oui')
    ->get();

    $pdf = new OrphelinPdf();
    $pdf->AddPage();
    $pdf->SetY(24);
    $compteur = 1;
    $count_etud = count($etudiants);
    foreach ($etudiants as $etudiant) {
      $pdf->SetX(8);
      $pdf->SetFont('aealarabiya', '', 10); // Police arabe
      // Données
      $pdf->Cell(80, 6, $etudiant->nom_ar . ' ' . $etudiant->prenom_ar, 1, 0, 'R', false); // Aligné à droite
      $pdf->Cell(40, 6, $etudiant->lastInscription->classe->abr_classe, 1, 0, 'R', false);
      $pdf->Cell(40, 6, $etudiant->type_orphelin, 1, 1, 'R', false);
      $compteur++;
      $count_etud = $count_etud - 1;
      // if ($pdf->GetY() + 45 > ($pdf->getPageHeight() - $pdf->getFooterMargin()) and $count_etud < 5) {
      //   $pdf->AddPage();
      // }
    }

    // Génération du PDF
    return $pdf->Output('etat_etudiants_' . date('Y-m-d') . '.pdf', 'I');
  }
}
