<div class="container mt-1">
  <div class="card">
    <div class="card-header bg-primary text-white py-2">
      <div class="d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
          <i class="fas fa-user-plus me-2"></i>Ajouter un Étudiant
        </h6>
        <a href="{{ route('etudiants.index') }}" class="btn btn-light btn-sm py-1">
          <i class="fas fa-arrow-left me-1"></i>Retour à la liste
        </a>
      </div>
    </div>

    <div class="card-body">
      <form wire:submit='save'>
        <div class="row g-1">
          <!-- Informations personnelles -->
          <div class="col-12">
            <h6 class="text-primary mb-1">
              <i class="fas fa-user me-2"></i>Informations personnelles
            </h6>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="num_enr" class="form-label">N° Enregistrement</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='num_enr' class='form-control @error("num_enr") is-invalid @enderror'
                  placeholder="Entrez le numero enregistrement">
              </div>
              @error('num_enr')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="code_massar" class="form-label">Code Massar</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='code_massar'
                  class='form-control @error("code_massar") is-invalid @enderror' placeholder="Entrez le code massar">
              </div>
              @error('code_massar')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group position-relative">
              @if ($etud_photo)
              <div class="position-absolute" style="top:-10px; right:-120px; z-index:2;">
                <img src="{{ $etud_photo->temporaryUrl() }}" alt="Aperçu" class="rounded-circle"
                  style="width:90px; height:90px; object-fit:cover; border:2px solid #ddd; background:#fff;" />
              </div>
              @endif
              <label for="etud_photo" class="form-label">Photo Étudiant</label>
              <div class="input-group align-items-center">
                <span class="input-group-text bg-light">
                  <i class="fas fa-image"></i>
                </span>
                <input type="file" wire:model="etud_photo"
                  class="form-control @error('etud_photo') is-invalid @enderror" accept="image/*">
              </div>
              @error('etud_photo')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="nom" class="form-label">Nom</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='nom' class='form-control @error("nom") is-invalid @enderror'
                  placeholder="Entrez le nom">
              </div>
              @error('nom')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="nom_ar" class="form-label text-end w-100">النسب</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='nom_ar' class='form-control @error("nom_ar") is-invalid @enderror'
                  placeholder="أدخل الاسم بالعربية" dir="rtl" lang="ar">
              </div>
              @error('nom_ar')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="prenom" class="form-label">Prénom</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='prenom' class='form-control @error("prenom") is-invalid @enderror'
                  placeholder="Entrez le prenom">
              </div>
              @error('prenom')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="prenom_ar" class="form-label text-end w-100" style="text-align: right;">الاسم</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='prenom_ar'
                  class='form-control @error("prenom_ar") is-invalid @enderror' placeholder="أدخل النسب بالعربية"
                  dir="rtl" lang="ar">
              </div>
              @error('prenom_ar')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="date_nais" class="form-label text-end w-100">تاريخ الازدياد</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar"></i>
                </span>
                <input type="text" wire:model='date_nais' id="datepicker"
                  class='form-control @error("date_nais") is-invalid @enderror' placeholder="JJ/MM/AAAA" dir="rtl"
                  lang="ar">
              </div>
              @error('date_nais')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lieu_naiss_ar" class="form-label text-end w-100">مكان الولادة</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='lieu_naiss_ar'
                  class='form-control @error("lieu_naiss_ar") is-invalid @enderror' placeholder="مكان الولادة بالعربية"
                  dir="rtl" lang="ar">
              </div>
              @error('lieu_naiss_ar')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="cin_ar" class="form-label text-end w-100">رقم البطاقةالوطنية</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='cin_ar' class='form-control @error("cin_ar") is-invalid @enderror'
                  dir="rtl" lang="ar">
              </div>
              @error('cin_ar')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="num_acte_nais" class="form-label text-end w-100">رقم عقد الازدياد</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.libe='num_acte_nais'
                  class='form-control @error("num_acte_nais") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('num_acte_nais')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="nom_pere" class="form-label text-end w-100">اسم الاب</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='nom_pere'
                  class='form-control @error("nom_pere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('nom_pere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="tel_pere" class="form-label text-end w-100">رقم هاتف الاب</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='tel_pere'
                  class='form-control @error("tel_pere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('tel_pere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="cin_pere" class="form-label text-end w-100">رقم البطاقة الوطنية للاب</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='cin_pere'
                  class='form-control @error("cin_pere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('cin_pere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="nom_mere" class="form-label text-end w-100">اسم الام</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='nom_mere'
                  class='form-control @error("nom_pere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('nom_mere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="tel_mere" class="form-label text-end w-100">رقم هاتف الام</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='tel_mere'
                  class='form-control @error("tel_mere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('tel_mere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="cin_mere" class="form-label text-end w-100">رقم البطاقة الوطنية للام</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='cin_mere'
                  class='form-control @error("cin_mere") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('cin_mere')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <div class="w-100 border rounded p-0" style="background:#f8f9fa;">
              <label for="sexe" class="form-label text-primary text-end w-100 mb-1"
                style="text-align:right;">الجنس</label>
              <div class="d-flex align-items-center justify-content-center gap-3" style="min-height:38px;">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="sexe" id="sexe_m" value="M" wire:model.live="sexe">
                  <label class="form-check-label" for="sexe_m">ذكر</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="sexe" id="sexe_f" value="F" wire:model.live="sexe">
                  <label class="form-check-label" for="sexe_f">انثى</label>
                </div>
              </div>
              @error('sexe')
              <div class="text-danger mt-1 text-center">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="adresse_ben" class="form-label text-end w-100">عنوان سكن المستفيد</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='adresse_ben'
                  class='form-control @error("adresse_ben") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('adresse_ben')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="dom_ter" class="form-label text-end w-100">المجال الترابي</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model='dom_ter' class='form-control @error("dom_ter") is-invalid @enderror'
                  dir="rtl" lang="ar">
              </div>
              @error('dom_ter')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="sit_soc" class="form-label text-end w-100">الوضعيةالاجتماعية</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                  <select wire:model.live='sit_soc' class='form-select @error("sit_soc") is-invalid @enderror' dir="rtl"
                  lang="ar">
                  <option value="">اختر الوضع الاجتماعي</option>
                  <option value="فقر">فقر</option>
                  <option value="متوسط الحال">متوسط الحال</option>
                  <option value="متخلى عنه">متخلى عنه</option>
                </select>
              </div>
              @error('sit_soc')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <div class="w-100 border rounded p-0" style="background:#f8f9fa;">
              <label for="sexe" class="form-label text-primary text-end w-100 mb-1" style="text-align:right;">في وضعية
                اعاقة؟</label>
              <div class="d-flex align-items-center justify-content-center gap-3" style="min-height:38px;">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="handicap" id="handicap_oui" value="oui"
                    wire:model.live="handicap">
                  <label class="form-check-label" for="handicap_oui">نعم</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="handicap" id="handicap_non" value="non"
                    wire:model.live="handicap">
                  <label class="form-check-label" for="handicap_non">لا</label>
                </div>
              </div>
              @error('handicap')
              <div class="text-danger mt-1 text-center">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="niv_scol" class="form-label text-end w-100">اسم المؤسسة</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <select wire:model.live='niv_scol' class='form-select @error("niv_scol") is-invalid @enderror' dir="rtl"
                  lang="ar">
                  <option value="">اسم المؤسسة</option>
                  <option value="IMAM MOUSLIM">IMAM MOUSLIM</option>
                  <option value="LYCEE CHAOUKI">LYCEE CHAOUKI</option>
                  <option value="LYCEE MOULAY ABDELLAH">LYCEE MOULAY ABDELLAH</option>
                </select>
              </div>
              @error('niv_scol')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="date_insc" class="form-label text-end w-100">تاريخ التحاقه بالمؤسسة</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar"></i>
                </span>
                <input type="text" wire:model.live='date_insc' id="date_insc"
                  class='form-control @error("date_insc") is-invalid @enderror' placeholder="JJ/MM/AAAA" dir="rtl"
                  lang="ar">
              </div>
              @error('date_insc')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="date_sortie" class="form-label text-end w-100">تاريخ مغادرة المؤسسة</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar"></i>
                </span>
                <input type="text" wire:model.live='date_sortie' id="date_sortie"
                  class='form-control @error("date_sortie") is-invalid @enderror' placeholder="JJ/MM/AAAA" dir="rtl"
                  lang="ar">
              </div>
              @error('date_sortie')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <div class="w-100 border rounded p-0" style="background:#f8f9fa;">
              <label for="sexe" class="form-label text-primary text-end w-100 mb-1" style="text-align:right;">هل الشخص
                يستفيد بالاشتراك؟</label>
              <div class="d-flex align-items-center justify-content-center gap-3" style="min-height:38px;">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="ben_part" id="ben_part_oui" value="oui"
                    wire:model.live="ben_part">
                  <label class="form-check-label" for="ben_part_oui">نعم</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="ben_part" id="ben_part_non" value="non"
                    wire:model.live="ben_part">
                  <label class="form-check-label" for="ben_part_non">لا</label>
                </div>
              </div>
              @error('ben_part')
              <div class="text-danger mt-1 text-center">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="mont_part" class="form-label text-end w-100">مبلغ الاشتراك (بالدرهم)</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" wire:model.live='mont_part'
                  class='form-control @error("mont_part") is-invalid @enderror' dir="rtl" lang="ar">
              </div>
              @error('mont_part')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>



          <!-- Inscription -->
          <div class="col-12">
            <h6 class="text-primary mb-3">
              <i class="fas fa-graduation-cap me-2"></i>Inscription
            </h6>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="classe" class="form-label">Niveau scolaire</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-chalkboard"></i>
                </span>
                <select wire:model.live='classe_id' class='form-select @error("classe_id") is-invalid @enderror'>
                  <option value="">Choix niveau</option>
                  @foreach ($classes as $classe)
                  <option value="{{ $classe->id }}">{{$classe->nom_classe}}</option>
                  @endforeach
                </select>
              </div>
              @error('classe_id')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="annscol" class="form-label">Année Scolaire</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar-alt"></i>
                </span>
                <input type="text" wire:model.live='annee_scol'
                  class='form-control @error("annee_scol") is-invalid @enderror' placeholder="Ex: 2023-2024">
              </div>
              @error('annee_scol')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center gap-2 mt-2">
          <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
            <i class="fas fa-times me-1"></i>Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@script()
<script>
  $(document).ready(function(){
    flatpickr("#datepicker", {
      dateFormat: "d/m/Y",
      locale: 'fr',
        allowInput: true,
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_nais', dateStr);
      }
    });
    flatpickr("#date_insc", {
      dateFormat: "d/m/Y",
      locale: 'fr',
      allowInput: true,
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_insc', dateStr);
      }
    });
    flatpickr("#date_sortie", {
      dateFormat: "d/m/Y",
      locale: 'fr',
      allowInput: true,
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_sortie', dateStr);
      }
    });
  })
</script>
@endscript