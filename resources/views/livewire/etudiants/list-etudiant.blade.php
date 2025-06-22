<div class="mt-2">
  <div class="card">
    <div class="card-header d-flex align-items-center py-2"
      style="justify-content:space-between; background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); box-shadow: 0 2px 8px rgba(0,0,0,0.05); min-height:48px;">
      <h5 class="card-title mb-0 flex-grow-1 text-white fw-bold"
        style="font-size:1.15rem; letter-spacing:1px; text-shadow:0 1px 4px rgba(0,0,0,0.12);">
        <i class="fas fa-users me-2"></i>Liste des Étudiants
        {{-- <span class="badge bg-light text-primary ms-2" style="font-size:1rem;">
          Année Scolaire
          {{ $annee_scol }}
        </span> --}}
      </h5>
      <a href="{{ route('etudiants.create') }}" class="btn btn-primary btn-sm ms-auto">
        <i class="fas fa-plus"></i> Nouvel Étudiant
      </a>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <div class="input-group" style="max-width: 900px;">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher...">
          <select wire:model.live='niv_scol' class='form-select ms-2' dir="rtl" lang="ar">
            <option value="">اختر المستوى الدراسي</option>
            <option value="IMAM MOUSLIM">IMAM MOUSLIM</option>
            <option value="LYCEE CHAOUKI">LYCEE CHAOUKI</option>
            <option value="LYCEE MOULAY ABDELLAH">LYCEE MOULAY ABDELLAH</option>
          </select>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Photo</th>
              <th wire:click="sortBy('nom')" style="cursor: pointer">
                Nom
                @if($sortField === 'nom')
                @if($sortDirection === 'asc') ↑ @else ↓ @endif
                @endif
              </th>
              <th wire:click="sortBy('prenom')" style="cursor: pointer">
                Prénom
                @if($sortField === 'prenom')
                @if($sortDirection === 'asc') ↑ @else ↓ @endif
                @endif
              </th>
              <th>N°Inscription</th>
              <th>Code Massar</th>
              <th>Etablissmeny</th>
              <th>Classe</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @php $i = ($etudiants instanceof \Illuminate\Pagination\LengthAwarePaginator) ?
            ($etudiants->currentPage() - 1) *
            $etudiants->perPage() + 1 : 1; @endphp
            @forelse($etudiants as $etudiant)
            <tr>
              <td>{{ $i++ }}</td>
              <td>
                @if($etudiant->etud_photo)
                <img src="{{ asset('storage/' . $etudiant->etud_photo) }}" alt="Photo" class="rounded-circle"
                  style="width:40px; height:40px; object-fit:cover;">
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ $etudiant->nom_ar }}</td>
              <td>{{ $etudiant->prenom }}</td>
              <td>{{ $etudiant->num_enr }}</td>
              <td>{{ $etudiant->code_massar }}</td>
              <td>{{ $etudiant->niv_scol }}</td>
              <td>{{ $etudiant->lastInscription?->classe?->nom_classe ?? 'Non assigné' }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button wire:click="delete({{ $etudiant->id }})" class="btn btn-danger btn-sm"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Aucun étudiant trouvé</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $etudiants->links() }}
      </div>
    </div>
  </div>
</div>