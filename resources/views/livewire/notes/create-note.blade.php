<div>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>Ajouter une Note
                @if($annee_scol)
                  - Année Scolaire {{ $annee_scol }}
                @endif
              </h5>
              <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
              </a>
            </div>
          </div>

          <div class="card-body">
            <form wire:submit="save">
              <!-- Recherche d'étudiant -->
              <div class="mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div style="width: 250px;">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-user-graduate"></i>
                      </span>
                      <input type="text" 
                        class="form-control border-start-0 rounded-end" 
                        placeholder="Rechercher un étudiant..." 
                        wire:model.live="searchEtudiant"
                        style="border-radius: 20px;">
                      <div wire:loading wire:target="searchEtudiant" class="input-group-text bg-white border-start-0">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                          <span class="visually-hidden">Chargement...</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  @if($selectedEtudiant)
                    <div class="d-flex align-items-center gap-2 flex-grow-1 bg-light p-2 rounded">
                      <i class="fas fa-user-check text-primary"></i>
                      <span class="fw-bold">{{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}</span>
                      @if($selectedEtudiant->inscriptions->isNotEmpty() && $selectedEtudiant->inscriptions->first()->classe)
                        <span class="badge bg-info">
                          <i class="fas fa-chalkboard me-1"></i>
                          {{ $selectedEtudiant->inscriptions->first()->classe->nom_classe }}
                        </span>
                        <span class="badge bg-secondary">
                          <i class="fas fa-calendar-alt me-1"></i>
                          {{ $selectedEtudiant->inscriptions->first()->annee_scol }}
                        </span>
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
                        <div class="d-flex gap-2">
                          @if($etudiant->inscriptions->isNotEmpty() && $etudiant->inscriptions->first()->classe)
                            <span class="badge bg-info">
                              <i class="fas fa-chalkboard me-1"></i>
                              {{ $etudiant->inscriptions->first()->classe->nom_classe }}
                            </span>
                            <span class="badge bg-secondary">
                              <i class="fas fa-calendar-alt me-1"></i>
                              {{ $etudiant->inscriptions->first()->annee_scol }}
                            </span>
                          @endif
                        </div>
                      </button>
                    @endforeach
                  </div>
                @endif

                @error('etudiant_id') 
                  <div class="invalid-feedback d-block">{{ $message }}</div> 
                @enderror
              </div>

              <div class="mb-3">
                <label for="matiere_id" class="form-label">Matière</label>
                <select wire:model="matiere_id" id="matiere_id" class="form-select" {{ !$matieres || $matieres->isEmpty() ? 'disabled' : '' }}>
                  <option value="">Sélectionnez une matière</option>
                  @if($matieres && $matieres->isNotEmpty())
                    @foreach($matieres as $matiere)
                      <option value="{{ $matiere->id }}">{{ $matiere->nom_matiere }}</option>
                    @endforeach
                  @endif
                </select>
                @error('matiere_id') <span class="text-danger">{{ $message }}</span> @enderror
                @if($etudiant_id && (!$matieres || $matieres->isEmpty()))
                  <span class="text-warning">Aucune matière disponible pour la classe de cet étudiant.</span>
                @endif
              </div>

              <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <div class="input-group">
                  <input type="text" 
                         wire:model.live="note" 
                         id="note" 
                         class="form-control" 
                         placeholder="Entrez la note (0-20)"
                         pattern="^\d*\.?\d{0,2}$"
                         oninput="this.value = this.value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.[\d]{2})./g, '$1');">
                  <span class="input-group-text">/20</span>
                </div>
                @error('note') 
                  <span class="text-danger">{{ $message }}</span> 
                @enderror
                @if($note_calc)
                  <div class="mt-2">
                    <small class="text-muted">
                      Note calculée (avec coefficient) : <strong>{{ $note_calc }}</strong>
                    </small>
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="semestre" class="form-label">Semestre</label>
                <select wire:model="semestre" id="semestre" class="form-select">
                  <option value="">Sélectionnez un semestre</option>
                  <option value="1">Semestre 1</option>
                  <option value="2">Semestre 2</option>
                </select>
                @error('semestre') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                  <i class="fas fa-times me-1"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-1"></i>Enregistrer
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>