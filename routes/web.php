<?php

use App\Livewire\Notes\SaisieNote;
use App\Livewire\Parents\CreateParent;
use App\Livewire\Parents\EditParent;
use App\Livewire\Parents\ListParent;
use App\Livewire\SuiviNote;
use App\Livewire\Notes\EditNote;
use App\Livewire\Notes\ListNote;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Notes\CreateNote;
use App\Livewire\Classes\ListClasse;
use App\Livewire\Classes\MajClasses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Classes\CreateClasse;
use App\Livewire\Matieres\ListMatiere;
use App\Livewire\Matieres\MajMatieres;
use App\Livewire\Etudiants\EditEtudiant;
use App\Livewire\Etudiants\ListEtudiant;
use App\Livewire\Matieres\CreateMatiere;
use App\Livewire\Etudiants\CreateEtudiant;
use App\Livewire\ClassesMatieres\ListClasseMatiere;
use App\Livewire\ClassesMatieres\MajClassesMatieres;
use App\Livewire\ClassesMatieres\CreateClasseMatiere;

Route::get('/', function () {
  return redirect('/login');
});
Auth::routes();
Route::middleware(['auth'])->group(function () {
  Route::get('/',Dashboard::class)->name('admin');
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
      // Route pour le suivi des notes
      Route::get('/suivi-notes', SuiviNote::class)->name('notes.suivi-notes');
      // Route pour lien parental
      Route::get('/parents', ListParent::class)->name('parents.index');
      Route::get('/parents/create', CreateParent::class)->name('parents.create');
      Route::get('/parents/{id}/edit', EditParent::class)->name('parents.edit');

  
});
