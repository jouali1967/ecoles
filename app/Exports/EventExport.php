<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EventExport implements FromArray, WithHeadings, WithEvents
{
  
  protected $evenements;

  public function __construct($evenements)
  {
    $this->evenements = $evenements;
  }

  public function array(): array
  {
    $rows = [];
    $i = 1;
    foreach ($this->evenements as $evenement) {
      $rows[] = [
        $i++,
        $evenement->etudiant->nom . ' ' . $evenement->etudiant->prenom,
        $evenement->etudiant->lastInscription->annee_scol,
        $evenement->etudiant->lastInscription->classe->abr_classe,
        $evenement->date_event,
        $evenement->description,
      ];
    }
    // Ajoute la ligne Total à la fin
    return $rows;
  }

  public function headings(): array
  {
    return [
      ['Liste des evenements'],
      [],
      ['N°', 'Nom et Prénom', 'Année_Scol', 'Niveau_scol', 'Date_event', 'Description'],
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
        $event->sheet->getColumnDimension('A')->setWidth(6);   // N°
        $event->sheet->getColumnDimension('B')->setWidth(30);  // Nom et prénom
        $event->sheet->getColumnDimension('C')->setWidth(10);  // Numéro de compte
        $event->sheet->getColumnDimension('D')->setWidth(12);  // Montant
        $event->sheet->getColumnDimension('E')->setWidth(12);  // Montant
        $event->sheet->getColumnDimension('F')->setWidth(40);  // Montant

        // Calcul dynamique de la position du tableau
        $headerCount = 0;
        foreach ($this->headings() as $heading) {
          $headerCount++;
          if ($heading ===['N°', 'Nom et Prénom', 'Année_Scol', 'Niveau_scol', 'Date_event', 'Description']) {
            break;
          }
        }
        $tableStart = $headerCount; // La ligne où commence le tableau (en-tête)
        $tableEnd = $tableStart + count($this->evenements); // La dernière ligne de données
        $totalRow = $tableEnd + 1; // La ligne du total

        // Centrer les deux titres sur 8 colonnes (A à H)
        $event->sheet->mergeCells('A1:F1');
        $event->sheet->mergeCells('A2:F2');
        $event->sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $event->sheet->getStyle('A1:F2')->getFont()->setBold(true);

        // Centrer les libellés du tableau (ligne d'en-tête)
        $event->sheet->getStyle('A' . $tableStart . ':F' . $tableStart)
          ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Alignement N° à centre (sauf l'en-tête)
        $event->sheet->getStyle('A' . ($tableStart + 1) . ':A' . $totalRow)
          ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Alignement à gauche pour toutes les autres cellules (B à H)
        $event->sheet->getStyle('B' . ($tableStart + 1) . ':F' . $tableEnd)
          ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Bordures sur tout le tableau
        $event->sheet->getStyle('A' . $tableStart . ':F' . $tableEnd)
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
