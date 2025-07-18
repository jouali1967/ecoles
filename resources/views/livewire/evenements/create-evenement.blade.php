<div class="card">
  <div class="card-header bg-primary text-white">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">
        <i class="fas fa-user-plus me-2"></i>Ajouter un Evenement
      </h5>
      {{-- <a wire:navigate href="{{ route('etudiants.index') }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Retour à la liste
      </a> --}}
    </div>
  </div>
  <div class="card-body">
    <form wire:submit="save">
      <!-- Recherche d'étudiant -->
      <div class="row g-1">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center gap-3">
                <div style="width: 250px;">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                      <i class="fas fa-user-graduate"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 rounded-end" placeholder="Rechercher..."
                      wire:model.live="searchEtudiant" style="border-radius: 20px;">
                    <div wire:loading wire:target="searchEtudiant" class="input-group-text bg-white border-start-0">
                      <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                      </div>
                    </div>
                  </div>
                </div>
                @if($selectedEtudiant)
                <div class="ms-3 d-flex align-items-center gap-3">
                  <span class="fw-bold text-primary">{{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}</span>
                  <span class="badge bg-secondary">N°: {{ $selectedEtudiant->num_enr }}</span>
                  <span class="badge bg-info text-dark">Massar: {{ $selectedEtudiant->code_massar }}</span>
                  @if($selectedEtudiant->lastInscription)
                  <span class="badge bg-success">
                    <i class="fas fa-chalkboard me-1"></i>
                    {{ $selectedEtudiant->lastInscription->classe?->nom_classe ?? 'Classe inconnue' }}
                  </span>
                  <span class="badge bg-light text-primary border">Année: {{
                    $selectedEtudiant->lastInscription->annee_scol }}</span>
                  @endif
                </div>
                @endif
              </div>
              @if($etudiants && $etudiants->count() > 0)
              <div class="list-group mt-2 shadow-sm" style="max-height: 200px; overflow-y: auto;">
                @foreach($etudiants as $etudiant)
                <button type="button"
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2"
                  wire:click="selectEtudiant({{ $etudiant->id }})">
                  <div>
                    <span class="fw-bold">{{ $etudiant->nom }}</span>
                    <span class="text-muted ms-2">{{ $etudiant->prenom }}</span>
                  </div>
                  @if($etudiant->inscriptions->isNotEmpty() && $etudiant->inscriptions->first()->classe)
                  <span class="badge bg-info">
                    <i class="fas fa-chalkboard me-1"></i>
                    {{ $etudiant->inscriptions->first()->classe->nom_classe }}
                  </span>
                  @endif
                </button>
                @endforeach
              </div>
              @endif
              @error('etudiant_id')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Bloc Ajout Moyenne -->
      {{-- @if($selectedEtudiant) --}}
      <div class="row g-1 mt-2">
        <div class="col-12">
          <h6 class="text-primary mb-3">
            <i class="fas fa-graduation-cap me-2"></i>Evenement Etudiant
          </h6>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="date_event" class="form-label">Date Evenement</label>
            <div class="input-group">
              <span class="input-group-text bg-light">
                <i class="fas fa-calendar"></i>
              </span>
              <input type="text" wire:model='date_event' id="date_event"
                class='form-control @error("date_event") is-invalid @enderror' placeholder="JJ/MM/AAAA">
            </div>
            @error('date_event')
            <div class="invalid-feedback d-block">{{$message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea wire:model.live='description' class='form-control @error("description") is-invalid @enderror'
              style="min-height: 80px; resize: vertical; border-radius: 10px; box-shadow: 0 1px 2px #eee;"
              placeholder="Entrez la description de l'événement"></textarea>
            @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="mt-2 text-end">
              <button type="submit" class="btn btn-success btn-sm px-4">
                <i class="fas fa-save me-1"></i>Enregistrer la description
              </button>
            </div>
          </div>
        </div>


      </div>
      {{-- @endif --}}

    </form>
  </div>
</div>
@script()
<script>
  $(document).ready(function(){
    flatpickr("#date_event", {
      dateFormat: "d/m/Y",
      locale: 'fr',
        allowInput: true,
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_event', dateStr);
      }
    });
  })
</script>
@endscript