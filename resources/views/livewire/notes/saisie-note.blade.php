<div>
  {{-- @dd($matieres) --}}
  <form wire:submit='save'>
    <div class="mb-4">
      <div class="d-flex align-items-center gap-3">
        <div style="width: 250px;">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-user-graduate"></i>
            </span>
            <input type="text" class="form-control border-start-0 rounded-end" placeholder="Rechercher un étudiant..."
              wire:model.live="searchEtudiant" style="border-radius: 20px;">
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
    {{-- --}}
    <div>
      @if($matieres && $matieres->isNotEmpty())
        <table class="table">
          <thead>
            <tr>
              <th>Matière</th>
              <th>Controle1</th>
              <th>Controle2</th>
              <th>Controle3</th>
              <th>Controle4</th>
            </tr>
          </thead>
          <tbody>
            @foreach($matieres as $matiere)
            @php
                $note = $notesEtudiant->get($matiere->id);
                //dd(vars: $note->note2)
            @endphp
            <tr>
              <td>{{ $matiere->nom_matiere }} (Coef: {{ optional($matiere->pivot)->coefficient ?? 'N/D' }})</td>
              <td>
                <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle1" class="form-control"
                  step="0.01" >
              </td>
              <td>
                <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle2" class="form-control"
                  step="0.01"  >
              </td>
              <td>
                <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle3" class="form-control"
                  step="0.01"   >
              </td>
              <td>
                <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle4" class="form-control"
                  step="0.01" >
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('notes.index') }}" class="btn btn-secondary">
            <i class="fas fa-times me-1"></i>Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Enregistrer
          </button>
        </div>
      @endif
    </div>
  </form>
</div>