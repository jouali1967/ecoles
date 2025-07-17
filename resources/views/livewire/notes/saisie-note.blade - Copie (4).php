<div>
  <div class="mb-4">
    <h4 class="fw-bold text-primary d-flex align-items-center gap-2"
      style="background: linear-gradient(90deg, #e3f0ff 0%, #f8fafc 100%); border-radius: 10px; padding: 10px 20px;">
      <i class="fas fa-pen-alt"></i>
      Saisie des notes
      <span class="badge bg-info text-dark ms-2">Semestre : {{ $semestre }}</span>
      @if($selectedEtudiant && $selectedEtudiant->lastInscription && $selectedEtudiant->lastInscription->classe)
      <span class="badge bg-primary ms-2">Classe : {{ $selectedEtudiant->lastInscription->classe->nom_classe }}
      </span>
      <span class="badge bg-secondary ms-2">Année : {{ $selectedEtudiant->lastInscription->annee_scol }}</span>
      @endif
    </h4>
  </div>
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
        <div style="width: 150px;">
          <select class="form-select form-select-sm" wire:model="semestre">
            <option value="">Choisir Semestre</option>
            <option value="1">Semestre 1</option>
            <option value="2">Semestre 2</option>
          </select>
        </div>
        <div style="width: 180px;">
          <select class="form-select form-select-sm" wire:model="annee_scol">
            <option value="">Année scolaire</option>
            @if($selectedEtudiant && count($annees_scolaires_etudiant) > 0)
            @foreach($annees_scolaires_etudiant as $annee)
            <option value="{{ $annee }}">{{ $annee }}</option>
            @endforeach
            @else
            @foreach($annees_scolaires as $annee)
            <option value="{{ $annee }}">{{ $annee }}</option>
            @endforeach
            @endif
          </select>
        </div>
        <div>
          <button type="button" class="btn btn-primary btn-sm" wire:click="rechercherEtudiant">
            <i class="fas fa-search"></i> Chercher
          </button>
        </div>

        @if($selectedEtudiant)
        <div class="d-flex align-items-center gap-2 flex-grow-1 bg-light p-2 rounded">
          <i class="fas fa-user-check text-primary"></i>
          <span class="fw-bold">{{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}</span>
          @if($selectedEtudiant->lastInscription && $selectedEtudiant->lastInscription->classe)
          <span class="badge bg-info">
            <i class="fas fa-chalkboard me-1"></i>
            {{ $selectedEtudiant->lastInscription->classe->nom_classe }}
          </span>
          <span class="badge bg-secondary">
            <i class="fas fa-calendar-alt me-1"></i>
            {{ $selectedEtudiant->lastInscription->annee_scol }}
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
            @if($etudiant->lastInscription && $etudiant->lastInscription->classe)
            <span class="badge bg-info">
              <i class="fas fa-chalkboard me-1"></i>
              {{ $etudiant->lastInscription->classe->nom_classe }}
            </span>
            <span class="badge bg-secondary">
              <i class="fas fa-calendar-alt me-1"></i>
              {{ $etudiant->lastInscription->annee_scol }}
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
                step="0.01" min="0" max="20" title="La note ne doit pas dépasser 20">
            </td>
            <td>
              <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle2" class="form-control"
                step="0.01" min="0" max="20" title="La note ne doit pas dépasser 20">
            </td>
            <td>
              <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle3" class="form-control"
                step="0.01" min="0" max="20" title="La note ne doit pas dépasser 20">
            </td>
            <td>
              <input type="number" wire:model.defer="notes.{{ $matiere->id }}.controle4" class="form-control"
                step="0.01" min="0" max="20" title="La note ne doit pas dépasser 20">
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