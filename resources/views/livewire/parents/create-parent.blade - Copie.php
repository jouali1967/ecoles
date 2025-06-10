<div class="card">
  <div class="card-header">
    <h5 class="card-title">Ajouter un Parent</h5>
  </div>
  <div class="card-body">
    <form wire:submit="save">
      <div class="row">
        <div class="col-md-12 mb-3">
          <style>
            .scrollable-table {
              max-height: 260px;
              overflow-y: auto;
            }

            .scrollable-table table {
              margin-bottom: 0;
            }
          </style>
          <div x-data="{ open: false }" class="position-relative">
            <label class="form-label">Ajouter une personne :</label>
            <div class="d-flex align-items-center gap-3">
              <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white">
                  <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Rechercher..." wire:model.live="searchEtudiant"
                  @focus="open = true" @input="open = true" @click.away="open = false">
              </div>

              @if($selectedEtudiant)
                <div class="alert alert-info py-2 mb-0">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>
                      <strong>{{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}</strong>
                      @if($selectedEtudiant->inscriptions->isNotEmpty() && $selectedEtudiant->inscriptions->first()->classe)
                        <span class="ms-2">| Classe : {{ $selectedEtudiant->inscriptions->first()->classe->nom_classe }}</span>
                      @endif
                    </span>
                  </div>
                </div>
              @endif
            </div>

            @if($etudiants && $etudiants->count() > 0)
              <ul class="list-group position-absolute mt-1 shadow"
                style="z-index: 1000; max-height: 250px; overflow-y: auto; width: 400px;" x-show="open" x-transition>
                @foreach($etudiants as $etudiant)
                  <li class="list-group-item list-group-item-action" style="cursor: pointer;"
                    wire:click="selectEtudiant({{ $etudiant->id }})" @click="open = false">
                    <div class="d-flex align-items-center">
                      <span class="fw-bold">{{ $etudiant->nom }}</span>
                      <span class="text-muted ms-2">{{ $etudiant->prenom }}</span>
                    </div>
                  </li>
                @endforeach
              </ul>
            @endif

            <div wire:loading wire:target="searchEtudiant"
              class="position-absolute top-50 end-0 translate-middle-y me-3">
              <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
              </div>
            </div>
          </div>
          @error('etudiant_id')
          <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="nom_pere" class="form-label">Nom du Père</label>
          <input type="text" wire:model="nom_pere" class="form-control @error('nom_pere') is-invalid @enderror">
          @error('nom_pere')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label for="phone_pere" class="form-label">Téléphone du Père</label>
          <input type="text" wire:model="phone_pere" class="form-control @error('phone_pere') is-invalid @enderror">
          @error('phone_pere')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="nom_mere" class="form-label">Nom de la Mère</label>
          <input type="text" wire:model="nom_mere" class="form-control @error('nom_mere') is-invalid @enderror">
          @error('nom_mere')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label for="phone_mere" class="form-label">Téléphone de la Mère</label>
          <input type="text" wire:model="phone_mere" class="form-control @error('phone_mere') is-invalid @enderror">
          @error('phone_mere')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <div class="form-check">
            <input type="checkbox" wire:model="handicape" class="form-check-input" id="handicape">
            <label class="form-check-label" for="handicape">Handicapé</label>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <div class="form-check">
            <input type="checkbox" wire:model="orphelin" class="form-check-input" id="orphelin">
            <label class="form-check-label" for="orphelin">Orphelin</label>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Enregistrer
        </button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">
          <i class="fas fa-times"></i> Annuler
        </a>
      </div>
    </form>
  </div>
</div>