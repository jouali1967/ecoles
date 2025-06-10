<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-edit me-2"></i>Modifier un Parent
            </h5>
            <a href="{{ route('parents.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>
    <div class="card-body">
        <form wire:submit="update">
            <!-- Informations de l'étudiant -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-2 bg-light p-2 rounded">
                        <i class="fas fa-user-graduate text-primary"></i>
                        <span class="fw-bold">{{ $parent->etudiant->nom }} {{ $parent->etudiant->prenom }}</span>
                        @if($parent->etudiant->inscriptions->isNotEmpty() && $parent->etudiant->inscriptions->first()->classe)
                            <span class="badge bg-info">
                                <i class="fas fa-chalkboard me-1"></i>
                                {{ $parent->etudiant->inscriptions->first()->classe->nom_classe }}
                            </span>
                        @endif
                        @if($parent->etudiant->email)
                            <span class="badge bg-secondary">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $parent->etudiant->email }}
                            </span>
                        @endif
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
                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" title="Entrez le nom complet du père"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" wire:model.live="nom_pere" class="form-control @error('nom_pere') is-invalid @enderror" id="nom_pere" placeholder="Entrez le nom du père">
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
                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" title="Format: +XX XXX XXX XXX"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" wire:model.live="phone_pere" class="form-control @error('phone_pere') is-invalid @enderror" id="phone_pere" placeholder="Entrez le numéro de téléphone">
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
                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" title="Entrez le nom complet de la mère"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" wire:model.live="nom_mere" class="form-control @error('nom_mere') is-invalid @enderror" id="nom_mere" placeholder="Entrez le nom de la mère">
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
                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" title="Format: +XX XXX XXX XXX"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" wire:model.live="phone_mere" class="form-control @error('phone_mere') is-invalid @enderror" id="phone_mere" placeholder="Entrez le numéro de téléphone">
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