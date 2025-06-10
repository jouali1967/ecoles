<div class='mt-2'>
    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Parents</h6>
                            <h2 class="mt-2 mb-0">{{ $parents->total() }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Handicapés</h6>
                            <h2 class="mt-2 mb-0">{{ $parents->where('handicape', true)->count() }}</h2>
                        </div>
                        <i class="fas fa-wheelchair fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Orphelins</h6>
                            <h2 class="mt-2 mb-0">{{ $parents->where('orphelin', true)->count() }}</h2>
                        </div>
                        <i class="fas fa-heart-broken fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Étudiants avec Parents</h6>
                            <h2 class="mt-2 mb-0">{{ $parents->unique('etudiant_id')->count() }}</h2>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-users me-2"></i>Liste des Parents
            </h5>
            <a href="{{ route('parents.create') }}" class="btn btn-light">
                <i class="fas fa-plus me-1"></i> Nouveau Parent
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Rechercher par nom d'étudiant ou parent...">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">
                        Affichage de {{ $parents->firstItem() ?? 0 }} à {{ $parents->lastItem() ?? 0 }} sur {{ $parents->total() }} parents
                    </span>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Père</th>
                            <th>Téléphone Père</th>
                            <th>Mère</th>
                            <th>Téléphone Mère</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($parents as $parent)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-graduate text-primary me-2"></i>
                                        <div>
                                            <div class="fw-bold">{{ $parent->etudiant->nom }} {{ $parent->etudiant->prenom }}</div>
                                            <small class="text-muted">{{ $parent->etudiant->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($parent->etudiant->inscriptions->isNotEmpty() && $parent->etudiant->inscriptions->first()->classe)
                                        <span class="badge bg-info">
                                            <i class="fas fa-chalkboard me-1"></i>
                                            {{ $parent->etudiant->inscriptions->first()->classe->nom_classe }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-male text-primary me-2"></i>
                                        {{ $parent->nom_pere }}
                                    </div>
                                </td>
                                <td>
                                    <a href="tel:{{ $parent->phone_pere }}" class="text-decoration-none">
                                        <i class="fas fa-phone-alt text-success me-1"></i>
                                        {{ $parent->phone_pere }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-female text-danger me-2"></i>
                                        {{ $parent->nom_mere }}
                                    </div>
                                </td>
                                <td>
                                    <a href="tel:{{ $parent->phone_mere }}" class="text-decoration-none">
                                        <i class="fas fa-phone-alt text-success me-1"></i>
                                        {{ $parent->phone_mere }}
                                    </a>
                                </td>
                                <td>
                                    @if($parent->handicape)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-wheelchair me-1"></i>Handicapé
                                        </span>
                                    @endif
                                    @if($parent->orphelin)
                                        <span class="badge bg-danger">
                                            <i class="fas fa-heart-broken me-1"></i>Orphelin
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-primary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="delete({{ $parent->id }})" class="btn btn-sm btn-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucun parent trouvé
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $parents->links() }}
            </div>
        </div>
    </div>
</div> 