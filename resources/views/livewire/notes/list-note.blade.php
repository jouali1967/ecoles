<div class="mt-2">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Liste des Notes - Année Scolaire {{ $annee_scol }}</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2" style="width: 400px;">
                    <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Rechercher un étudiant ou une matière..." style="width: 250px;">
                    <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvelle Note
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('created_at')" style="cursor: pointer">
                                Date
                                @if($sortField === 'created_at')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('etudiant_id')" style="cursor: pointer">
                                Étudiant
                                @if($sortField === 'etudiant_id')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th>Année Scolaire</th>
                            <th wire:click="sortBy('matiere_id')" style="cursor: pointer">
                                Matière
                                @if($sortField === 'matiere_id')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('note')" style="cursor: pointer">
                                Note
                                @if($sortField === 'note')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('note_calc')" style="cursor: pointer">
                                Note Calculée
                                @if($sortField === 'note_calc')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('semestre')" style="cursor: pointer">
                                Semestre
                                @if($sortField === 'semestre')
                                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            <tr>
                                <td>{{ $note->created_at->format('d/m/Y') }}</td>
                                <td>{{ $note->etudiant->nom }} {{ $note->etudiant->prenom }}</td>
                                <td>{{ $note->annee_scol }}</td>
                                <td>{{ $note->matiere->nom_matiere }}</td>
                                <td>{{ number_format($note->note, 2) }}/20</td>
                                <td>{{ number_format($note->note_calc, 2) }}</td>
                                <td>Semestre {{ $note->semestre }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="delete({{ $note->id }})" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune note trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $notes->links() }}
            </div>
        </div>
    </div>
</div> 