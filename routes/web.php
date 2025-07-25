<?php

use App\Livewire\Notes\ListNote;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Notes\SuiviNote;
use App\Livewire\Notes\SaisieNote;
use App\Livewire\Classes\ListClasse;
use App\Livewire\Classes\MajClasses;
use App\Livewire\Editions\ListBenif;
use App\Livewire\Parents\EditParent;
use App\Livewire\Parents\ListParent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EtudiantPdf;
use Illuminate\Support\Facades\Route;
use App\Livewire\Archives\ListArchive;
use App\Livewire\Classes\CreateClasse;
use App\Livewire\Editions\ScoreFilter;
use App\Livewire\Matieres\ListMatiere;
use App\Livewire\Matieres\MajMatieres;
use App\Livewire\Parents\CreateParent;
use App\Livewire\Editions\EtatEtudiant;
use App\Livewire\Editions\ListHandicap;
use App\Livewire\Editions\ListOrphelin;
use App\Livewire\Archives\CreateArchive;
use App\Livewire\Editions\ListEtudSuivi;
use App\Livewire\Etudiants\EditEtudiant;
use App\Livewire\Etudiants\ListEtudiant;
use App\Livewire\Matieres\CreateMatiere;
use App\Livewire\Editions\ScoreEtudiants;
use App\Http\Controllers\ScoreEtudiantPdf;
use App\Livewire\Editions\ListTeritoriale;
use App\Livewire\Etudiants\CreateEtudiant;
use App\Livewire\Evenements\EditEvenement;
use App\Livewire\Evenements\ListeEvenement;
use App\Livewire\Evenements\CreateEvenement;
use App\Http\Controllers\ListBenifController;
use App\Http\Controllers\ListTeritController;
use App\Livewire\Etudiants\CreateInscription;
use App\Http\Controllers\EvenementsController;
use App\Http\Controllers\FilterScoreController;
use App\Http\Controllers\HandicapPdfController;
use App\Http\Controllers\OrphelinPdfController;
use App\Http\Controllers\ArchiveFilterController;
use App\Livewire\ClassesMatieres\ListClasseMatiere;
use App\Livewire\ClassesMatieres\MajClassesMatieres;
use App\Livewire\ClassesMatieres\CreateClasseMatiere;

Route::get('/', function () {
  return redirect('/login');
});
Auth::routes();
Route::middleware(['auth'])->group(function () {
  Route::get('/', Dashboard::class)->name('admin');
  // Routes pour les classes
  Route::get('/classes', MajClasses::class)->name('classes.maj');
  Route::get('/classes/index', ListClasse::class)->name('classes.index');
  Route::get('/classes/create', CreateClasse::class)->name('classes.create');
  // Routes pour les matières
  Route::get('/matieres', MajMatieres::class)->name('matieres.maj');
  Route::get('/matieres/index', ListMatiere::class)->name('matieres.index');
  Route::get('/matieres/create', CreateMatiere::class)->name('matieres.create');

  // Routes pour les classes-matieres
  Route::get('/classes-matieres', ListClasseMatiere::class)->name('classes-matieres.index');
  Route::get('/classes-matieres/create', CreateClasseMatiere::class)->name('classes-matieres.create');
  Route::get('/classes-matieres/{classeMatiere}/edit', MajClassesMatieres::class)->name('classes-matieres.edit');
  // Routes pour les étudiants
  Route::get('/etudiants', ListEtudiant::class)->name('etudiants.index');
  Route::get('/etudiants/create', CreateEtudiant::class)->name('etudiants.create');
  Route::get('/etudiants/{etudiant}/edit', EditEtudiant::class)->name('etudiants.edit');
  // Routes pour les notes
  //Route::get('/notes/create', CreateNote::class)->name('notes.create');
  Route::get('/notes', ListNote::class)->name('notes.index');
  //Route::get('/notes{note}/edit', EditNote::class)->name('notes.edit');
  Route::get('/notes/saisie', SaisieNote::class)->name('notes.saisie');
  Route::get('/notes/suivi', ListEtudSuivi::class)->name('notes.etud.suivi');
  
  // Route pour le suivi des notes
  Route::get('notes/suivi-notes', SuiviNote::class)->name('notes.suivi-notes');
  // Route pour lien parental
  /*Route::get('/parents', ListParent::class)->name('parents.index');
      Route::get('/parents/create', CreateParent::class)->name('parents.create');
      Route::get('/parents/{id}/edit', EditParent::class)->name('parents.edit');*/

  //inscriptions
  Route::get('/inscriptions/create', CreateInscription::class)->name('etudiants.create.insc');
  //editions
  Route::get('/editions/etudiants', EtatEtudiant::class)->name('editions.etat.etudiant');
  Route::get('/editions/etudiants/pdf', [EtudiantPdf::class, 'generate'])->name('editions.etat_etud.pdf');
  Route::get('/editions/score', ScoreEtudiants::class)->name('editions.score.etudiants');
  Route::get('/editions/score/pdf', [ScoreEtudiantPdf::class, 'generate'])->name('editions.score.pdf');
  Route::get('/editions/moyenne/pdf', [ScoreEtudiantPdf::class, 'exporter'])->name('notes.suivietud.pdf');

  Route::get('/editions/filter/pdf', [FilterScoreController::class, 'generate'])->name('editions.filter.pdf');
  Route::get('/editions/filter', ScoreFilter::class)->name('editions.filter.etudiants');

  Route::get('/editions/listbenif', ListBenif::class)->name('editions.listbenif.etudiants');
  Route::get('/editions/listbenif/pdf', [ListBenifController::class, 'generate'])->name('editions.listbenif.pdf');
  Route::get('/editions/listbenif/excel', [ListBenifController::class, 'generate_excel'])->name('editions.listbenif.excel');

  Route::get('/editions/listterit', ListTeritoriale::class)->name('editions.listterit.etudiants');
  Route::get('/editions/listterir/pdf', [ListTeritController::class, 'generate'])->name('editions.listterit.pdf');

  Route::get('/editions/orphelin', ListOrphelin::class)->name('editions.orphelin.etudiants');
  Route::get('/editions/orphelin/pdf', [OrphelinPdfController::class, 'generate'])->name('editions.orphelin.pdf');
  Route::get('/editions/orphelin/excel', [OrphelinPdfController::class, 'generate_excel'])->name('editions.orphelin.excel');
  
  Route::get('/editions/handicap', ListHandicap::class)->name('editions.listhandicap.etudiants');
  Route::get('/editions/handicap/pdf', [HandicapPdfController::class, 'generate'])->name('editions.handicap.pdf');
  Route::get('/editions/handicap/excel', [HandicapPdfController::class, 'generate_excel'])->name('editions.handicap.excel');

  Route::get('/archives', ListArchive::class)->name('archives.index.etudiants');
  Route::get('/archives/create', CreateArchive::class)->name('archives.create.etudiants');
  Route::get('/archives/edit/{etudiant_id}/{annee_scol}', \App\Livewire\Archives\EditArchive::class)->name('archives.edit');
  Route::get('/archives/filter/pdf', [ArchiveFilterController::class, 'generate'])->name('archives.filter.pdf');
  //evenements
  Route::get('/evenements/create',CreateEvenement::class)->name('evenements.create');
  Route::get('/evenements/liste',ListeEvenement::class)->name('evenements.index');
  Route::get('/evenements/{id}/edit', EditEvenement::class)->name('evenements.edit');
  Route::get('/evenements/excel', [EvenementsController::class, 'generate_excel'])->name('evenements.excel');

});
