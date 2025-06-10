<div>
  <div class="container mt-1">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white py-2">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="card-title mb-0">
                <i class="fas fa-edit me-2"></i>Modifier l'association Classe-Matière
              </h6>
              <a href="{{ route('classes-matieres.index') }}" class="btn btn-light btn-sm py-1">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
              </a>
            </div>
          </div>

          <div class="card-body">
            @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if (session()->has('message'))
            <div class="alert alert-success" role="alert">
              <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
            </div>
            @endif

            <form wire:submit="update">
              <div class="row g-3">
                <!-- Sélection -->
                <div class="col-12">
                  <h6 class="text-primary mb-1">
                    <i class="fas fa-list me-2"></i>Sélection
                  </h6>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="classe_id" class="form-label">Classe</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">
                        <i class="fas fa-chalkboard"></i>
                      </span>
                      <select wire:model="classe_id" 
                              id="classe_id" 
                              class="form-select @error('classe_id') is-invalid @enderror">
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->nom_classe }}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('classe_id') 
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="matiere_id" class="form-label">Matière</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">
                        <i class="fas fa-book"></i>
                      </span>
                      <select wire:model="matiere_id" 
                              id="matiere_id" 
                              class="form-select @error('matiere_id') is-invalid @enderror">
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom_matiere }}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('matiere_id') 
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Coefficient -->
                <div class="col-12">
                  <h6 class="text-primary mb-1">
                    <i class="fas fa-calculator me-2"></i>Coefficient
                  </h6>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="coefficient" class="form-label">Valeur</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">
                        <i class="fas fa-hashtag"></i>
                      </span>
                      <input wire:model="coefficient" 
                             type="number" 
                             min="1" 
                             id="coefficient" 
                             class="form-control @error('coefficient') is-invalid @enderror"
                             placeholder="Entrez le coefficient">
                    </div>
                    @error('coefficient') 
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-center gap-2 mt-2">
                <a href="{{ route('classes-matieres.index') }}" class="btn btn-secondary">
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