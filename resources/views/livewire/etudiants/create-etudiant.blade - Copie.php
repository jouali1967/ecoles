<div>
  <div class="container mt-1">
    <div class="card">
      <div class="card-header bg-primary text-white py-2">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="card-title mb-0">
            <i class="fas fa-user-plus me-2"></i>Ajouter un Étudiant
          </h6>
          <a href="{{ route('etudiants.index') }}" class="btn btn-light btn-sm py-1">
            <i class="fas fa-arrow-left me-1"></i>Retour à la liste
          </a>
        </div>
      </div>

      <div class="card-body">
        <form wire:submit='save'>
          @csrf
          <div class="row g-3">
            <!-- Informations personnelles -->
            <div class="col-12">
              <h6 class="text-primary mb-1">
                <i class="fas fa-user me-2"></i>Informations personnelles
              </h6>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="nom" class="form-label">Nom</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" wire:model='nom' class='form-control @error("nom") is-invalid @enderror'
                    placeholder="Entrez le nom">
                </div>
                @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="prenom" class="form-label">Prénom</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" wire:model='prenom' class='form-control @error("prenom") is-invalid @enderror'
                    placeholder="Entrez le prénom">
                </div>
                @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="nom_ar" class="form-label">الاسم (Nom en arabe)</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" wire:model='nom_ar' class='form-control @error("nom_ar") is-invalid @enderror'
                    placeholder="أدخل الاسم بالعربية" dir="rtl" lang="ar">
                </div>
                @error('nom_ar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="prenom_ar" class="form-label">النسب (Prénom en arabe)</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" wire:model='prenom_ar' class='form-control @error("prenom_ar") is-invalid @enderror'
                    placeholder="أدخل النسب بالعربية" dir="rtl" lang="ar">
                </div>
                @error('prenom_ar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="date_nais" class="form-label">Date de naissance</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-calendar"></i>
                  </span>
                  <input type="text" wire:model='date_nais' id="datepicker"
                    class='form-control @error("date_nais") is-invalid @enderror' placeholder="JJ/MM/AAAA">
                </div>
                @error('date_nais')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="adresse" class="form-label">Adresse</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                  <input type="text" wire:model='adresse' class='form-control @error("adresse") is-invalid @enderror'
                    placeholder="Entrez l'adresse">
                </div>
                @error('adresse')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Coordonnées -->
            <div class="col-12">
              <h6 class="text-primary mb-3">
                <i class="fas fa-address-card me-2"></i>Coordonnées
              </h6>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" class="form-label">Téléphone</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-phone"></i>
                  </span>
                  <input type="text" wire:model='phone' class='form-control @error("phone") is-invalid @enderror'
                    placeholder="Entrez le numéro de téléphone">
                </div>
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-envelope"></i>
                  </span>
                  <input type="email" wire:model='email' class='form-control @error("email") is-invalid @enderror'
                    placeholder="Entrez l'adresse email">
                </div>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Inscription -->
            <div class="col-12">
              <h6 class="text-primary mb-3">
                <i class="fas fa-graduation-cap me-2"></i>Inscription
              </h6>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="classe" class="form-label">Classe</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-chalkboard"></i>
                  </span>
                  <select wire:model='classe_id' class='form-select @error("classe_id") is-invalid @enderror'>
                    <option value="">Choisir une classe</option>
                    @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{$classe->nom_classe}}</option>
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
                <label for="annscol" class="form-label">Année Scolaire</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-calendar-alt"></i>
                  </span>
                  <input type="text" wire:model='annee_scol' class='form-control @error("annee_scol") is-invalid @enderror'
                    placeholder="Ex: 2023-2024">
                </div>
                @error('annee_scol')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-2 mt-2">
            <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
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

@script()
<script>
  $(document).ready(function(){
    flatpickr("#datepicker", {
      dateFormat: "d/m/Y",
      locale: 'fr',
      allowInput: true,
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_nais', dateStr);
      }
    });
  })
</script>
@endscript