<div>
  <style>
    .card-header.py-2 {
      padding-top: 0.25rem !important;
      padding-bottom: 0.25rem !important;
      min-height: 32px !important;
      height: 32px !important;
    }

    .card-header .card-title {
      font-size: 1rem;
      line-height: 1.2;
    }
  </style>
  <div class="mt-2">
    <div class="card">
      <div class="card-header py-2">
        <h6 class="card-title mb-0">
          <i class="fas fa-chart-line me-1"></i>Liste des etudiants
        </h6>
      </div>
      <div class="card-body p-2">
        <form wire:submit.prevent="rechercher">
          <div class="row g-2 align-items-end">
            <div class="col-md-3">
              <div class="form-group mb-0">
                <label for="annee_inscription" class="form-label small">Année scolaire</label>
                <select wire:model="annee_inscription" id="annee_inscription" class="form-select form-select-sm">
                  <option value="">Sélectionnez une année inscription</option>
                  @foreach($annee_inscriptions as $annee)
                  <option value="{{ $annee }}">{{ $annee }}</option>
                  @endforeach
                </select>
                @error('annee_inscription') <span class="text-danger small">{{ $message }}</span> @enderror
              </div>
            </div>

            {{-- <div class="col-md-3">
              <div class="form-group mb-0">
                <label for="niv_scol" class="form-label small">Niveau Scolaire</label>
                <select wire:model="niv_scol" id="niv_scol" class="form-select form-select-sm">
                  <option value="">Sélectionnez niveau scolaire</option>
                  <option value="COLLEGE">COLLEGE</option>
                  <option value="LYCEE">LYCEE</option>
                </select>
                @error('niv_scol') <span class="text-danger small">{{ $message }}</span> @enderror
              </div>
            </div> --}}
            <div class="col-md-3">
              <div class="form-group mb-0">
                <label for="scol_lib" class="form-label small">Niveau Scolaire</label>
                <select wire:model='scol_lib' class='form-select @error("scol_lib") is-invalid @enderror' dir="rtl"
                  lang="ar">
                  <option value="">اختر المستوى الدراسي</option>
                  <option value="IMAM MOUSLIM">IMAM MOUSLIM</option>
                  <option value="LYCEE CHAOUKI">LYCEE CHAOUKI</option>
                  <option value="LYCEE MOULAY ABDELLAH">LYCEE MOULAY ABDELLAH</option>
                </select>
                @error('scol_lib') <span class="text-danger small">{{ $message }}</span> @enderror
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
              <th>Niveau scolaire</th>
              <th>Classe</th>
              <th>Année inscription</th>
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
                @if($etudiant->etud_photo)
                <img src="{{ asset('uploads/' . $etudiant->etud_photo) }}" alt="Photo" class="rounded-circle"
                  style="width:40px; height:40px; object-fit:cover;">
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ $etudiant->num_enr }}</td>
              <td>{{ $etudiant->code_massar }}</td>
              <td>{{ $etudiant->nom }}</td>
              <td>{{ $etudiant->prenom }}</td>
              <td>{{ $etudiant->niv_scol }}</td>
              <td>{{ optional($etudiant->lastInscription->classe)->nom_classe ?? '-' }}</td>
              <td>{{ $etudiant->date_insc }}</td>
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