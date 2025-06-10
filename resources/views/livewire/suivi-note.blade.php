<div class="mt-2">
  <div class="card">
    <div class="card-header py-2">
      <h6 class="card-title mb-0">
        <i class="fas fa-chart-line me-1"></i>Suivi des Notes
      </h6>
    </div>
    <div class="card-body p-2">
      <form wire:submit.prevent="rechercher">
        <div class="row g-2 align-items-end">
          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="annee_scolaire" class="form-label small">Année scolaire</label>
              <select wire:model="annee_scolaire" id="annee_scolaire" class="form-select form-select-sm">
                <option value="">Sélectionnez une année scolaire</option>
                @foreach($annees_scolaires as $annee)
                <option value="{{ $annee }}">{{ $annee }}</option>
                @endforeach
              </select>
              @error('annee_scolaire') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="semestre" class="form-label small">Semestre</label>
              <select wire:model="semestre" id="semestre" class="form-select form-select-sm">
                <option value="">Sélectionnez un semestre</option>
                <option value="1">Semestre 1</option>
                <option value="2">Semestre 2</option>
              </select>
              @error('semestre') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group mb-0">
              <label for="nom_etudiant" class="form-label small">Étudiant</label>
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

              @if($etudiants && $etudiants->count() > 0)
                <div class="list-group mt-1 shadow-sm" style="max-height: 150px; overflow-y: auto;">
                  @foreach($etudiants as $etudiant)
                    <button type="button" 
                      class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-1"
                      wire:click="selectEtudiant({{ $etudiant->id }})">
                      <div>
                        <span class="fw-bold">{{ $etudiant->nom }}</span>
                        <span class="text-muted ms-2">{{ $etudiant->prenom }}</span>
                      </div>
                      @if($etudiant->inscriptions->isNotEmpty() && $etudiant->inscriptions->first()->classe)
                        <span class="badge bg-info">
                          <i class="fas fa-chalkboard me-1"></i>
                          {{ $etudiant->inscriptions->first()->classe->nom_classe }}
                        </span>
                      @endif
                    </button>
                  @endforeach
                </div>
              @endif

              @error('nom_etudiant') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">
              <i class="fas fa-search"></i> Rechercher
            </button>
          </div>
        </div>
      </form>

      @if($showResults && $etudiant)
      <div class="mt-2">
        <div class="card">
          <div class="card-header bg-primary text-white py-1">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-0">
                <i class="fas fa-user-graduate me-1"></i>
                {{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}
              </h6>
              <div>
                <span class="badge bg-info me-1">
                  <i class="fas fa-chalkboard me-1"></i>
                  {{ $classe }}
                </span>
                <span class="badge bg-secondary me-1">
                  <i class="fas fa-calendar-alt me-1"></i>
                  {{ $annee_scolaire }}
                </span>
                <span class="badge bg-warning">
                  <i class="fas fa-clock me-1"></i>
                  Semestre {{ $semestre }}
                </span>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            @if(count($notes) > 0)
            <div class="table-responsive" style="max-height: calc(100vh - 250px);">
              <table class="table table-sm table-hover table-striped table-bordered mb-0">
                <thead class="table-light sticky-top">
                  <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th>Matière</th>
                    <th class="text-center" style="width: 8%">Controle 1</th>
                    <th class="text-center" style="width: 8%">Controle 2</th>
                    <th class="text-center" style="width: 8%">Controle 3</th>
                    <th class="text-center" style="width: 8%">Controle 4</th>
                    <th class="text-center" style="width: 12%">Note Calculée</th>
                    <th class="text-center" style="width: 12%">Coefficient</th>
                    <th class="text-center" style="width: 12%">Note Pondérée</th>
                    <th class="text-center" style="width: 12%">Statut</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $totalCoefficient = 0;
                    $totalNotePonderee = 0;
                  @endphp
                  @foreach($notes as $index => $note)
                  
                    @php
                      $noteFinale = null;
                      if ($note->note_calc !== null) {
                          $noteFinale = $note->note_calc;
                      } else {
                          $notesPartielles = array_filter([$note->note1, $note->note2, $note->note3, $note->note4], function($n) { return $n !== null; });
                          if (count($notesPartielles) > 0) {
                              $noteFinale = array_sum($notesPartielles) / count($notesPartielles);
                          }
                      }
                      
                      $notePonderee = ($noteFinale !== null) ? $noteFinale * $note->coefficient : null;
                      $totalCoefficient += $note->coefficient;
                      $totalNotePonderee += ($notePonderee !== null) ? $notePonderee : 0;
                    @endphp
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $note->matiere }}</td>
                      <td class="text-center">
                        @if($note->note1 !== null)
                          <span class="badge {{ $note->note1 >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($note->note1, 2) }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($note->note2 !== null)
                          <span class="badge {{ $note->note2 >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($note->note2, 2) }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($note->note3 !== null)
                          <span class="badge {{ $note->note3 >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($note->note3, 2) }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($note->note4 !== null)
                          <span class="badge {{ $note->note4 >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($note->note4, 2) }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($note->note_calc !== null)
                          <span class="badge {{ $note->note_calc >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($note->note_calc, 2) }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td class="text-center">{{ $note->coefficient }}</td>
                      <td class="text-center">
                        @if($notePonderee !== null)
                          {{ number_format($notePonderee, 2) }}
                        @else
                          -
                        @endif
                      </td>
                      <td class="text-center">
                        @if($noteFinale !== null)
                          @if($noteFinale >= 10)
                            <span class="badge bg-success">
                              <i class="fas fa-check-circle me-1"></i>Validé
                            </span>
                          @else
                            <span class="badge bg-danger">
                              <i class="fas fa-times-circle me-1"></i>Non validé
                            </span>
                          @endif
                        @else
                          <span class="badge bg-warning">
                            <i class="fas fa-exclamation-circle me-1"></i>En attente
                          </span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  <tr class="table-primary sticky-bottom">
                    <td colspan="2" class="text-end fw-bold">Moyenne générale :</td>
                    <td class="text-center fw-bold" colspan="5">
                      @if($totalCoefficient > 0)
                        {{ number_format($totalNotePonderee / $totalCoefficient, 2) }}
                      @else
                        -
                      @endif
                    </td>
                    <td class="text-center fw-bold">{{ $totalCoefficient }}</td>
                    <td class="text-center fw-bold">{{ number_format($totalNotePonderee, 2) }}</td>
                    <td class="text-center">
                      @if($totalCoefficient > 0)
                        @php $moyenne = $totalNotePonderee / $totalCoefficient; @endphp
                        @if($moyenne >= 10)
                          <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Validé
                          </span>
                        @else
                          <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>Non validé
                          </span>
                        @endif
                      @else
                        -
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            @else
            <div class="alert alert-info m-3">
              <i class="fas fa-info-circle me-2"></i>
              Aucune note trouvée pour cette période.
            </div>
            @endif
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>