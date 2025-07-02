<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Resultats Scolaires</h5>
  </div>
  <div class="card-body">
    <form wire:submit.prevent="filterArchives" class="row g-2 mb-3 align-items-end justify-content-center">
      @if ($errors->any())
      <div class="col-12">
        <div class="alert alert-danger py-2 mb-2">
          <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif
      <div class="col-auto">
        <label for="annee_scol" class="form-label small mb-0 me-2">Année scolaire</label>
        <select wire:model="annee_scolaire" id="annee_scol" class="form-select form-select-sm d-inline-block w-auto"
          style="min-width: 160px;">
          <option value="">Sélectionnez une année scolaire</option>
          @foreach($annees_scolaires as $annee)
          <option value="{{ $annee }}">{{ $annee }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto">
        <label for="sup_a" class="form-label small mb-0 me-2">Moy &gt; </label>
        <input type="number" step="0.01" wire:model="sup_a" id="sup_a"
          class="form-control form-control-sm d-inline-block w-auto" style="min-width: 80px;">
      </div>
      <div class="col-auto">
        <label for="inf_a" class="form-label small mb-0 me-2">Moy &lt; </label>
        <input type="number" step="0.01" wire:model="inf_a" id="inf_a"
          class="form-control form-control-sm d-inline-block w-auto" style="min-width: 80px;">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="fas fa-search me-1"></i>Rechercher
        </button>
      </div>
    </form>
    @if($showResults)
    @if($archives->count())
    <div class="mb-2 d-flex justify-content-end">
      <input type="text" wire:model.live="search" class="form-control form-control-sm w-auto"
        placeholder="Recherche rapide..." style="min-width:200px;">
    </div>
    <table class="table table-bordered table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Code Massar</th>
          <th>Classe</th>
          <th>Moy. Semestre 1</th>
          <th>Moy. Semestre 2</th>
          <th>Moyenne</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($archives as $archive)
        <tr>
          <td>{{ $archive->etudiant->nom ?? '-' }}</td>
          <td>{{ $archive->etudiant->prenom ?? '-' }}</td>
          <td>{{ $archive->etudiant->code_massar ?? '-' }}</td>
          <td>{{ $archive->etudiant->lastInscription->classe->abr_classe ?? '-' }}</td>
          <td>{{ is_null($archive->moy_s1) ? '-' : number_format($archive->moy_s1, 2) }}</td>
          <td>{{ is_null($archive->moy_s2) ? '-' : number_format($archive->moy_s2, 2) }}</td>
          <td>{{ number_format($archive->moyenne_annuelle, 2) }}</td>
          <td>
            <a href="{{ route('archives.edit', [$archive->etudiant_id, str_replace('/', '-', $archive->annee_scol)]) }}"
              class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i> Edit
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-2 d-flex justify-content-center">
      {{ $archives->links() }}
    </div>
    @else
    <div class="alert alert-info text-center">Aucune archive trouvée.</div>
    @endif
    @endif
  </div>
</div>