<div class="mt-2">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Liste matieres</h5>
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <th>Nom Matiere</th>
          <th>Description</th>
          <th>Actions</th>
        </thead>
        <tbody>
          @foreach ($matieres as $matiere)
              <tr>
                <td>{{ $matiere->nom_matiere }}</td>
                <td>{{ $matiere->description }}</td>
                <td><button wire:click.prevent="removeMatiere({{ $matiere->id }})" class="btn btn-danger btn-sm">X</button></td>
              </tr>
          @endforeach
        </tbody>
      </table>
      {{ $matieres->links() }}
    </div>
    
  </div>
</div>
