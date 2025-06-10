<div>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0">
                <i class="fas fa-edit me-2"></i>Modifier une Note
              </h5>
              <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
              </a>
            </div>
          </div>

          <div class="card-body">
            <form wire:submit="save">
              <!-- Informations de l'étudiant -->
              <div class="mb-4">
                <div class="d-flex align-items-center gap-2 bg-light p-3 rounded">
                  <i class="fas fa-user-graduate text-primary fs-4"></i>
                  <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h6>
                    @if($etudiant->inscriptions->isNotEmpty() && $etudiant->inscriptions->first()->classe)
                      <div class="d-flex gap-2">
                        <span class="badge bg-info">
                          <i class="fas fa-chalkboard me-1"></i>
                          {{ $etudiant->inscriptions->first()->classe->nom_classe }}
                        </span>
                        <span class="badge bg-secondary">
                          <i class="fas fa-calendar-alt me-1"></i>
                          {{ $etudiant->inscriptions->first()->annee_scol }}
                        </span>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="matiere" class="form-label">Matière</label>
                    <select wire:model.live="matiere_id" 
                            class="form-select @error('matiere_id') is-invalid @enderror" 
                            id="matiere">
                      <option value="">Sélectionner une matière</option>
                      @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">
                          {{ $matiere->nom_matiere }} 
                          @if(isset($matiere->pivot) && isset($matiere->pivot->coefficient))
                            (Coeff: {{ $matiere->pivot->coefficient }})
                          @endif
                        </option>
                      @endforeach
                    </select>
                    @error('matiere_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="semestre" class="form-label">Semestre</label>
                    <select wire:model="semestre" 
                            class="form-select @error('semestre') is-invalid @enderror" 
                            id="semestre">
                      <option value="">Sélectionner un semestre</option>
                      <option value="1">Semestre 1</option>
                      <option value="2">Semestre 2</option>
                    </select>
                    @error('semestre')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="note" class="form-label">Note</label>
                    <div class="input-group">
                      <input type="text" 
                             wire:model.live="note_value" 
                             class="form-control @error('note_value') is-invalid @enderror" 
                             id="note" 
                             placeholder="Entrez la note (0-20)"
                             pattern="^\d*\.?\d{0,2}$"
                             oninput="this.value = this.value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.[\d]{2})./g, '$1');">
                      <span class="input-group-text">/20</span>
                    </div>
                    @error('note_value')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="note_calc" class="form-label">Note Calculée</label>
                    <div class="input-group">
                      <input type="text" 
                             class="form-control bg-light" 
                             id="note_calc" 
                             value="{{ number_format($note_calc, 2) }}" 
                             readonly>
                      <span class="input-group-text bg-light">
                        <i class="fas fa-calculator"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end gap-2 mt-4">
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