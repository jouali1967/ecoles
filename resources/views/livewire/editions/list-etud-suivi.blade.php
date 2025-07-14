<div class="mt-2">
  <div class="card">
    <div class="card-header py-2">
      <h6 class="card-title mb-0">
        <i class="fas fa-chart-line me-1"></i>Score Etudiants
      </h6>
    </div>
    <div class="card-body p-2">
      <form wire:submit.prevent="rechercher">
        <div class="row g-2 align-items-end">
          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="annee_scolaire" class="form-label small">Année scolaire</label>
              <select wire:model="annee_scolaire" id="annee_scolaire" class="form-select form-select-sm">
                <option value="">Sélectionnez une année scolaire</option>
                @foreach($annees_scolaires as $annee)
                <option value="{{ $annee }}">{{ $annee }}</option>
                @endforeach
              </select>
              @error('annee_scolaire') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="semestre" class="form-label small">Semestre</label>
              <select wire:model="semestre" id="semestre" class="form-select form-select-sm">
                <option value="">Sélectionnez un semestre</option>
                <option value="1">Semestre 1</option>
                <option value="2">Semestre 2</option>
              </select>
              @error('semestre') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="matiere_id" class="form-label small">Matieres</label>
              <select wire:model="matiere_id" id="matiere_id" class="form-select form-select-sm">
                <option value="">Sélectionnez une matiere</option>
                @foreach($matieres as $id=>$nom_matiere)
                <option value="{{ $id }}">{{ $nom_matiere }}</option>
                @endforeach
              </select>
              @error('matiere_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>


          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">
              <i class="fas fa-search"></i> Rechercher
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
  @if($etudiants && count($etudiants) > 0)
  <div class="card mt-3">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
      <h6 class="card-title mb-0"><i class="fas fa-users me-1"></i> Résultats</h6>
      <button wire:click="imprimer" class="btn btn-outline-secondary btn-sm ms-auto" style="float:left">
        <i class="fas fa-print"></i> Imprimer
      </button>
    </div>
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table table-bordered table-sm mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Photo</th>
              <th>N° Insc.</th>
              <th>Code massar</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Classe</th>
              <th>Moyenne</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @php $i = ($etudiants instanceof \Illuminate\Pagination\LengthAwarePaginator) ?
            ($etudiants->currentPage() - 1) *
            $etudiants->perPage() + 1 : 1; @endphp
            @foreach($etudiants as $etudiant)
            <tr>
              <td>{{ $i++ }}</td>
              <td>
                @if($etudiant->etudiant->etud_photo)
                <img src="{{ asset('uploads/' . $etudiant->etudiant->etud_photo) }}" alt="Photo" class="rounded-circle"
                  style="width:40px; height:40px; object-fit:cover;">
                @else
                <span class="text-muted">-</span>
                @endif

              </td>
              <td>{{ $etudiant->etudiant->num_enr }}</td>
              <td>{{ $etudiant->etudiant->code_massar }}</td>
              <td>{{ $etudiant->etudiant->nom }}</td>
              <td>{{ $etudiant->etudiant->prenom }}</td>
              <td>
                @php
                $classe = null;
                if($etudiant->etudiant && $etudiant->etudiant->inscriptions) {
                $insc = $etudiant->etudiant->inscriptions->where('annee_scol', $annee_scolaire)->first();
                if($insc && $insc->classe) {
                $classe = $insc->classe->nom_classe;
                }
                }
                @endphp
                @if($classe)
                {{ $classe }}
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ number_format($etudiant->moyenne, 2, ',', ' ') }}</td>
              <td>
                @if($etudiant->moyenne >= 10)
                <span class="badge bg-success">
                  <i class="fas fa-check-circle me-1"></i>Validé
                </span>
                @else
                <span class="badge bg-danger">
                  <i class="fas fa-times-circle me-1"></i>Non validé
                </span>
                @endif

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @if(method_exists($etudiants, 'links'))
    <div class="mt-2">
      {{ $etudiants->links() }}
    </div>
    @endif
  </div>
  @else
  <div class="alert alert-info mt-3">Aucun étudiant trouvé.</div>
  @endif
</div>
</div>
@script()
<script>
  $(document).ready(function(){
    window.addEventListener('openEtatWindow', event => {
      // Access the URL from the event detail
      const url = event.detail.url;
      if (url) {
        window.open(url, '_blank');
      } else {
        // Fallback or error handling if URL is not provided, though it should be
        console.error('PDF URL not provided in event detail.');
      }
    });
  })
</script>
@endscript