<div class="mt-2">
  <div class="card">
    <div class="card-header py-2">
      <h6 class="card-title mb-0">
        <i class="fas fa-chart-line me-1"></i>Liste Etudiants الجماعات الترابية
      </h6>
    </div>
    <div class="card-body p-2">
      <form wire:submit.prevent="rechercher">
        <div class="row g-2 align-items-end">
          <div class="col-md-3">
            <div class="form-group mb-0">
              <label for="dom_ter" class="form-label text-end w-100">المجال الترابي</label>
                <select wire:model.live='dom_ter' class='form-select @error("dom_ter") is-invalid @enderror' dir="rtl"
                  lang="ar">
                  <option value="">اختر المجال الترابي</option>
                  <option value="جماعة مولاي عبدالله">جماعة مولاي عبدالله</option>
                  <option value="جماعة الجديدة">جماعة الجديدة</option>
                  <option value="جماعة الحوزية">جماعة الحوزية</option>
                  <option value="جماعة اولاد احسين">جماعة اولاد احسين</option>
                  <option value="جماعة سيدي عابد">جماعة سيدي عابد</option>
                  <option value="جماعة الشعيبات">جماعة الشعيبات</option>
                </select>
              @error('dom_ter') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">
              <i class="fas fa-search"></i> Rechercher
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
  @if($etudiants && count($etudiants) > 0)
  <div class="card mt-3">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
      <h6 class="card-title mb-0"><i class="fas fa-users me-1"></i> Résultats</h6>
      <button wire:click="imprimer" class="btn btn-outline-secondary btn-sm ms-auto" style="float:left">
        <i class="fas fa-print"></i> Imprimer
      </button>
    </div>
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table table-bordered table-sm mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Photo</th>
              <th>N° Insc.</th>
              <th>Code massar</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Classe</th>
              <th>Tel des parents</th>
            </tr>
          </thead>
          <tbody>
            @php $i = ($etudiants instanceof \Illuminate\Pagination\LengthAwarePaginator) ?
            ($etudiants->currentPage() - 1) *
            $etudiants->perPage() + 1 : 1; @endphp
            @foreach($etudiants as $etudiant)
            <tr>
              <td>{{ $i++ }}</td>
              <td>
                @if($etudiant->etud_photo)
                <img src="{{ asset('uploads/' . $etudiant->etud_photo) }}" alt="Photo" class="rounded-circle"
                  style="width:40px; height:40px; object-fit:cover;">
                @else
                <span class="text-muted">-</span>
                @endif

              </td>
              <td>{{ $etudiant->num_enr }}</td>
              <td>{{ $etudiant->code_massar }}</td>
              <td class="text-end">{{ $etudiant->nom_ar }}</td>
              <td class="text-end">{{ $etudiant->prenom_ar }}</td>
              <td class="text-end">{{ $etudiant->abr_classe }}</td>
              <td class="text-end">{{ $etudiant->tel_pere ?? $etudiant->tel_mere ?? '' }} </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @if(method_exists($etudiants, 'links'))
    <div class="mt-2">
      {{ $etudiants->links() }}
    </div>
    @endif
  </div>
  @else
  <div class="alert alert-info mt-3">Aucun étudiant trouvé.</div>
  @endif
</div>
</div>
@script()
<script>
  $(document).ready(function(){
    window.addEventListener('openEtatWindow', event => {
      // Access the URL from the event detail
      const url = event.detail.url;
      if (url) {
        window.open(url, '_blank');
      } else {
        // Fallback or error handling if URL is not provided, though it should be
        console.error('PDF URL not provided in event detail.');
      }
    });
  })
</script>
@endscript

