<div class="card">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Liste des Événements</h5>
  </div>
  <div class="card-body p-3">
    <div class="mb-3">
      <div class="input-group" style="max-width: 300px;">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher...">
      </div>
    </div>
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>N°</th>
          <th>Nom et Prenom</th>
          <th>Annee_Scol</th>
          <th>Niveau_Scol</th>
          <th>Date_event</th>
          <th>Description</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @php $i = ($evenements instanceof \Illuminate\Pagination\LengthAwarePaginator) ?
        ($evenements->currentPage() - 1) *
        $evenements->perPage() + 1 : 1; @endphp
        @forelse($evenements as $event)
        <tr>
          <td>{{ $i++ }}</td>
          <td>{{ $event->etudiant->nom }} {{ $event->etudiant->prenom }}</td>
          <td>{{ $event->etudiant->lastInscription->annee_scol }}</td>
          <td>{{ $event->etudiant->lastInscription->classe->abr_classe }}</td>
          <td>{{ $event->date_event ? $event->date_event : '' }}</td>
          <td>{{ $event->description }}</td>
          <td class="text-end">
            <a wire:navigate href="{{ route('evenements.edit', $event->id) }}" class="btn btn-sm btn-warning me-1"
              title="Modifier">
              <i class="fas fa-edit"></i>
            </a>
            <span class="position-relative d-inline-block">
              <button type="button" class="btn btn-sm btn-danger" title="Supprimer" onclick="showConfirm(this)">
                <i class="fas fa-trash-alt"></i>
              </button>
              <span
                class="confirm-tooltip shadow rounded bg-white px-2 py-1 border position-absolute d-flex align-items-center gap-2"
                style="visibility:hidden; opacity:0; transition:opacity 0.15s; z-index:10; right:0; top:110%; min-width:180px; min-height:38px;">
                <span class="me-2" style="white-space:nowrap;">Confirmer la suppression&nbsp;?</span>
                <button type="button" class="btn btn-danger btn-sm py-0 px-2" style="font-size:0.9em;"
                  onclick="event.stopPropagation(); event.preventDefault(); confirmDelete(this)">Oui</button>
                <button type="button" class="btn btn-secondary btn-sm py-0 px-2" style="font-size:0.9em;"
                  onclick="event.stopPropagation(); event.preventDefault(); hideConfirm(this)">Non</button>
              </span>
              <form wire:submit.prevent="delete({{ $event->id }})" style="display:none"></form>
            </span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center text-muted">Aucun événement trouvé.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{ $evenements->links() }}
    </tbody>
    </table>
  </div>
</div>
<script>
  function showConfirm(btn) {
    document.querySelectorAll('.confirm-tooltip').forEach(e => { e.style.visibility = 'hidden'; e.style.opacity = 0; });
      let tooltip = btn.parentElement.querySelector('.confirm-tooltip');
      if (tooltip) {
          tooltip.style.visibility = 'visible';
          tooltip.style.opacity = 1;
      }
      document.addEventListener('click', function hide(e) {
          if (!btn.parentElement.contains(e.target)) {
              tooltip.style.visibility = 'hidden';
              tooltip.style.opacity = 0;
              document.removeEventListener('click', hide);
          }
      });
  }
  function confirmDelete(btn) {
      const form = btn.closest('.position-relative').querySelector('form');
      if(form) form.requestSubmit ? form.requestSubmit() : form.submit();
  }
  function hideConfirm(btn) {
      const tooltip = btn.closest('.confirm-tooltip');
      if(tooltip) {
          tooltip.style.visibility = 'hidden';
          tooltip.style.opacity = 0;
      }
  }
</script>