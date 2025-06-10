<div class="mt-2">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Ajout Matiere</h5>
      <form wire:submit='save'>
        <div class="form-group mb-2">
          <label for="nom">Nom Matiere</label>
          <input type="text" wire:model='nom_matiere' class='form-control'>
          @error('nom_matiere')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group mb-2">
          <label for="description">Description</label>
          <input type="text" wire:model='description' class='form-control'>
          @error('description')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div>
          <input type="submit" class="btn btn-success btn-sm" value="Save">
        </div>
      </form>
    </div>
  </div>
</div>
