<div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Liste Niveau Scolaire</h5>
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <th>Nom Classe</th>
          <th>Actions</th>
        </thead>
        <tbody>
          @foreach ($classes as $classe)
              <tr>
                <td>{{ $classe->nom_classe }}</td>
                <td>
                  <button wire:click="edit({{ $classe->id }})" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button wire:click="removeClass({{ $classe->id }})" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
      {{ $classes->links() }}
    </div>
    
  </div>
</div>
