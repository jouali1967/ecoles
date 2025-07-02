<div class="card">
  <div class="card-header bg-primary text-white">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">
        <i class="fas fa-user-plus me-2"></i>Ajouter Moyenne Etudiant
      </h5>
      {{-- <a wire:navigate href="{{ route('etudiants.index') }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Retour à la liste
      </a> --}}
    </div>
  </div>
  <div class="card-body">
    <form wire:submit="save">
      @if (session()->has('error'))
      <div class="alert alert-danger mb-2">{{ session('error') }}</div>
      @endif
      @if (session()->has('success'))
      <div class="alert alert-success mb-2">{{ session('success') }}</div>
      @endif
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
      @if($selectedEtudiant)
      <div class="row g-1 mt-2">
        <div class="col-12">
          <h6 class="text-primary mb-3">
            <i class="fas fa-graduation-cap me-2"></i>Moyenne Etudiant
          </h6>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="annee_scol" class="form-label">Année Scolaire</label>
            <div class="input-group">
              <span class="input-group-text bg-light">
                <i class="fas fa-calendar-alt"></i>
              </span>
              <input type="text" wire:model.live='annee_scol'
                class='form-control @error("annee_scol") is-invalid @enderror' placeholder="Ex: 2023/2024">
            </div>
            @error('annee_scol')
            <div class="invalid-feedback d-block">{{ $message}}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group mb-0">
            <label for="semestre" class="form-label small">Semestre</label>
            <select wire:model.live="semestre" id="semestre" class="form-select form-select-sm">
              <option value="">Sélectionnez un semestre</option>
              <option value="1">Semestre 1</option>
              <option value="2">Semestre 2</option>
            </select>
            @error('semestre') <span class="text-danger small">{{$message}}</span> @enderror
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="classe" class="form-label">Niveau Scolaire</label>
            <div class="input-group">
              <span class="input-group-text bg-light">
                <i class="fas fa-chalkboard"></i>
              </span>
              <select wire:model.live='classe_id' class='form-select @error("classe_id") is-invalid @enderror'>
                <option value="">Choisir niveau scolaire</option>
                @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{$classe->nom_classe}}</option>
                @endforeach
              </select>
            </div>
            @error('classe_id')
            <div class="invalid-feedback d-block">{{ $message}}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="moyenne" class="form-label">Moyenne</label>
            <div class="input-group">
              <span class="input-group-text bg-light">
                <i class="fas fa-chalkboard"></i>
              </span>
              <input type="text" wire:model.live='moyenne' class='form-control @error("moyenne") is-invalid @enderror'>
            </div>
            @error('moyenne')
            <div class="invalid-feedback d-block">{{ $message}}</div>
            @enderror
          </div>
        </div>

      </div>
      @endif

      <!-- Boutons d'action -->
      @if($selectedEtudiant)
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-end gap-2">
            {{-- <a href="{{ route('parents.index') }}" class="btn btn-secondary">
              <i class="fas fa-times me-1"></i>Annuler
            </a> --}}
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-1"></i>Enregistrer
            </button>
          </div>
        </div>
      </div>
      @endif
    </form>
  </div>
</div>