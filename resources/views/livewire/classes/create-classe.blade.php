<div>
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">{{ $editing ? 'Modifier Niveau scolaire' : 'Ajouter Niveau scolaire' }}</h5>
    </div>
    <div class="card-body">
      <form wire:submit.prevent="save">
        <div class="form-group mb-3">
          <label for="nom_classe" class="form-label">Nom de la classe</label>
          <input type="text" wire:model="nom_classe" class="form-control" id="nom_classe">
          @error('nom_classe') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
          <label for="abr_classe" class="form-label">Abrviation de la classe</label>
          <input type="text" wire:model="abr_classe" class="form-control" id="abr_classe">
          @error('abr_classe') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ $editing ? 'Mettre à jour' : 'Enregistrer' }}
          </button>
          @if($editing)
            <button type="button" wire:click="cancel" class="btn btn-secondary">
              <i class="fas fa-times"></i> Annuler
            </button>
          @endif
        </div>
      </form>
    </div>
  </div>
</div>