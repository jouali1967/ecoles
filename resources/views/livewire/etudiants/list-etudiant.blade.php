<div class="mt-2">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Liste des Étudiants - Année Scolaire {{ $annee_scol }}</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2" style="width: 400px;">
                    <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Rechercher un étudiant..." style="width: 250px;">
                    <a href="{{ route('etudiants.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvel Étudiant
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('nom')" style="cursor: pointer">
                                Nom
                                @if($sortField === 'nom')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('prenom')" style="cursor: pointer">
                                Prénom
                                @if($sortField === 'prenom')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th>Date de Naissance</th>
                            <th>Classe</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom }}</td>
                                <td>{{ $etudiant->prenom }}</td>
                                <td>{{ $etudiant->date_nais }}</td>
                                <td>{{ $etudiant->classe->nom_classe ?? 'Non assigné' }}</td>
                                <td>{{ $etudiant->email }}</td>
                                <td>{{ $etudiant->phone }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="delete({{ $etudiant->id }})" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun étudiant trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $etudiants->links() }}
            </div>
        </div>
    </div>
</div>
