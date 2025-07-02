<div class="card mt-3">
  <div class="card-header bg-warning text-dark">
    <h5 class="mb-0">Modifier les moyennes de l'étudiant</h5>
  </div>
  <div class="card-body">
    <a href="{{ route('archives.index.etudiants') }}" class="btn btn-secondary btn-sm mb-3">
      <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Semestre</th>
          <th>Moyenne</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($archives as $i => $archive)
        <tr>
          <td>{{ $archive['semestre'] }}</td>
          <td>
            @if($editIndex === $i)
            <form wire:submit.prevent="saveEdit({{ $archive['id'] }})" class="d-flex align-items-center gap-2">
              <input type="number" step="0.01" min="0" max="20" wire:model.defer="editMoyenne"
                class="form-control form-control-sm w-auto" style="max-width:90px;">
              <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
              <button type="button" class="btn btn-secondary btn-sm" wire:click="cancelEdit">Annuler</button>
            </form>
            @error('editMoyenne')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @else
            {{ $archive['moyenne'] }}
            @endif
          </td>
          <td>
            @if($editIndex === $i)
            <span class="text-muted">En édition...</span>
            @else
            <button class="btn btn-sm btn-primary" wire:click="startEdit({{ $i }})">Modifier</button>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>