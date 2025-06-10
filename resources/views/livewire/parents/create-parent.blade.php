<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-plus me-2"></i>Ajouter un Parent
            </h5>
            <a href="{{ route('parents.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <!-- Recherche d'étudiant -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 250px;">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-user-graduate"></i>
                                        </span>
                                        <input type="text" 
                                            class="form-control border-start-0 rounded-end" 
                                            placeholder="Rechercher..." 
                                            wire:model.live="searchEtudiant"
                                            style="border-radius: 20px;">
                                        <div wire:loading wire:target="searchEtudiant" class="input-group-text bg-white border-start-0">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Chargement...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($selectedEtudiant)
                                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                                        <i class="fas fa-user-check text-primary"></i>
                                        <span class="fw-bold">{{ $selectedEtudiant->nom }} {{ $selectedEtudiant->prenom }}</span>
                                        @if($selectedEtudiant->inscriptions->isNotEmpty() && $selectedEtudiant->inscriptions->first()->classe)
                                            <span class="badge bg-info">
                                                <i class="fas fa-chalkboard me-1"></i>
                                                {{ $selectedEtudiant->inscriptions->first()->classe->nom_classe }}
                                            </span>
                                        @endif
                                        @if($selectedEtudiant->email)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-envelope me-1"></i>
                                                {{ $selectedEtudiant->email }}
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

                            @error('etudiant_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations du père -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3">
                        <i class="fas fa-male text-primary me-2"></i>Informations du Père
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom_pere" class="form-label">
                            Nom du Père <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" 
                                wire:model="nom_pere" 
                                class="form-control @error('nom_pere') is-invalid @enderror" 
                                placeholder="Entrez le nom du père">
                            @error('nom_pere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_pere" class="form-label">
                            Téléphone du Père <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" 
                                wire:model="phone_pere" 
                                class="form-control @error('phone_pere') is-invalid @enderror" 
                                placeholder="Entrez le numéro de téléphone">
                            @error('phone_pere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de la mère -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3">
                        <i class="fas fa-female text-danger me-2"></i>Informations de la Mère
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom_mere" class="form-label">
                            Nom de la Mère <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" 
                                wire:model="nom_mere" 
                                class="form-control @error('nom_mere') is-invalid @enderror" 
                                placeholder="Entrez le nom de la mère">
                            @error('nom_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_mere" class="form-label">
                            Téléphone de la Mère <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" 
                                wire:model="phone_mere" 
                                class="form-control @error('phone_mere') is-invalid @enderror" 
                                placeholder="Entrez le numéro de téléphone">
                            @error('phone_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>Statut
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input type="checkbox" wire:model="handicape" class="form-check-input" id="handicape">
                                <label class="form-check-label" for="handicape">
                                    <i class="fas fa-wheelchair text-warning me-1"></i>Handicapé
                                    <i class="fas fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Cochez cette case si l'étudiant est en situation de handicap"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input type="checkbox" wire:model="orphelin" class="form-check-input" id="orphelin">
                                <label class="form-check-label" for="orphelin">
                                    <i class="fas fa-heart-broken text-danger me-1"></i>Orphelin
                                    <i class="fas fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Cochez cette case si l'étudiant est orphelin"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('parents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', function () {
        // Initialiser les tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endpush