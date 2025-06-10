<div>
    <div class="container mt-1">
        <div class="card">
            <div class="card-header bg-primary text-white py-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Liste des Associations Classes-Matières
                    </h6>
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input wire:model.live="search" type="text" class="form-control" placeholder="Rechercher...">
                        </div>
                        <a href="{{ route('classes-matieres.create') }}" class="btn btn-light btn-sm py-1">
                            <i class="fas fa-plus me-1"></i>Nouvelle Association
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-2">
                                    <i class="fas fa-chalkboard me-1"></i>Classe
                                </th>
                                <th class="py-2">
                                    <i class="fas fa-book me-1"></i>Matière
                                </th>
                                <th class="py-2">
                                    <i class="fas fa-hashtag me-1"></i>Coefficient
                                </th>
                                <th class="py-2 text-center">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classesMatieres as $classeMatiere)
                                <tr>
                                    <td>{{ $classeMatiere->classe->nom_classe }}</td>
                                    <td>{{ $classeMatiere->matiere->nom_matiere }}</td>
                                    <td>{{ $classeMatiere->coefficient }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('classes-matieres.edit', ['classeMatiere'=>$classeMatiere]) }}" class="btn btn-info" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="delete({{ $classeMatiere->id }})" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?')" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">
                                        <i class="fas fa-info-circle me-2"></i>Aucune association trouvée
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $classesMatieres->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
