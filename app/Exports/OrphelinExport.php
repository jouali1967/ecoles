<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrphelinExport implements FromArray, WithHeadings, WithEvents
{

  protected $etudiants;

  public function __construct($etudiants)
  {
    $this->etudiants = $etudiants;
  }

  public function array(): array
  {
    $rows = [];
    foreach ($this->etudiants as $etudiant) {
      $rows[] = [
        // Ordre inversé pour l'arabe : téléphone, classe, nom complet, code massar
        $etudiant->type_orphelin,
        $etudiant->lastInscription->classe->abr_classe,
        $etudiant->nom_ar . ' ' . $etudiant->prenom_ar,
        $etudiant->code_massar,
      ];
    }
    return $rows;
  }

  public function headings(): array
  {
    return [
      ['لائحة الايتام'],
      [],
      // Ordre inversé pour l'arabe : téléphone, classe, nom complet, code massar
      ['نوع اليتم', 'المستوى الدراسي', 'الاسم والنسب', 'رقم مسار'],
    ];
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {
        // Setup A4 portrait
        $event->sheet->getPageSetup()->setFitToWidth(1);
        $event->sheet->getPageSetup()->setFitToHeight(0);
        $event->sheet->getPageSetup()->setOrientation(
          \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT
        );
        $event->sheet->getPageSetup()->setPaperSize(
          \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4
        );

        // Largeurs
        $event->sheet->getColumnDimension('A')->setWidth(20);   // N°
        $event->sheet->getColumnDimension('B')->setWidth(30);  // Nom et prénom
        $event->sheet->getColumnDimension('C')->setWidth(15);  // Numéro de compte
        $event->sheet->getColumnDimension('D')->setWidth(15);  // Montant

        // Calcul dynamique de la position du tableau
        $headerCount = 0;
        foreach ($this->headings() as $heading) {
          $headerCount++;
          if ($heading === ['نوع اليتم', 'المستوى الدراسي', 'الاسم والنسب', 'رقم مسار']) {
            break;
          }
        }
        $tableStart = $headerCount; // La ligne où commence le tableau (en-tête)
        $tableEnd = $tableStart + count($this->etudiants); // La dernière ligne de données
        $totalRow = $tableEnd + 1; // La ligne du total


        // Centrer les deux titres
        $event->sheet->mergeCells('A1:D1');
        $event->sheet->mergeCells('A2:D2');
        $event->sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $event->sheet->getStyle('A1:D2')->getFont()->setBold(true);

        // Centrer les libellés du tableau (ligne d'en-tête)
        $event->sheet->getStyle('A' . $tableStart . ':D' . $tableStart)
          ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Alignement à droite pour toutes les cellules du tableau (A à D)
        $event->sheet->getStyle('A' . ($tableStart + 1) . ':D' . $tableEnd)
          ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Bordures sur tout le tableau
        $event->sheet->getStyle('A' . $tableStart . ':D' . $tableEnd)
          ->applyFromArray([
            'borders' => [
              'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
              ],
            ],
          ]);
      },
    ];
  }
}
