<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\Personne;

class PdfPersonneController extends Controller
{
    public function generate()
    {
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Système de Gestion');
        $pdf->SetAuthor('Votre Entreprise');
        $pdf->SetTitle('Liste des Personnes');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 15);
        // Désactiver l'en-tête
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false); // Optionnel : désactiver le pied de page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Liste des Personnes', 0, 1, 'C');
        $pdf->Ln(10);

        $personnes = Personne::all();
        foreach ($personnes as $personne) {
            $pdf->Cell(0, 10, $personne->nom, 0, 1);
        }

        return $pdf->Output('liste_personnes.pdf', 'I'); // 'I' pour afficher dans le navigateur
    }
}
