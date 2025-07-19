<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Exports\EventExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EvenementsController extends Controller
{
    public function generate_excel(Request $request){
      $search = $request->query('search', '');
      $evenements = Evenement::with([
        'etudiant.lastInscription.classe'
      ])
    ->latest('date_event')
     ->when($search, function ($query) use($search) {
      $query->whereHas('etudiant', function ($q) use($search) {
          $q->where('nom', 'like', '%' . $search . '%')
            ->orWhere('prenom', 'like', '%' . $search . '%')
            ->orWhere('code_massar', 'like', '%' . $search . '%');
      });
    })
    ->get();
    return Excel::download(new EventExport($evenements), 'evenements.xlsx');
    }
}
