<x-dashboard-layout>
    <style>
        @keyframes fadeInScale { 0% { opacity: 0; transform: translateY(6px) scale(.98); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        .form-step[data-active="true"] { animation: fadeInScale .28s ease-out; }
    </style>
    <div class="px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto py-6">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
            <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">Pengajuan Surat Baru</h1>
            <a href="{{ route('permohonan.warga.index') }}" class="text-primary hover:underline">Permohonan Saya</a>
        </div>

        <form method="POST" action="{{ route('permohonan.warga.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6 rounded-2xl p-4 md:p-6 border border-slate-200/80 dark:border-slate-700/70 bg-gradient-to-br from-white to-slate-50 dark:from-slate-900 dark:to-slate-900/60 shadow-sm">
            @csrf

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col gap-3 p-4 md:p-6 border rounded-xl bg-white/80 backdrop-blur dark:bg-slate-800/50 dark:border-slate-700">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap justify-between items-center gap-3">
                        <p class="text-sm md:text-base font-medium leading-normal" id="current-step-text">Langkah 1 dari 3: Pilih Layanan</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400" id="progress-percentage">33% Selesai</p>
                    </div>
                    <!-- Stepper -->
                    <div class="relative">
                        <div class="absolute left-6 right-6 top-4 h-0.5 bg-slate-200 dark:bg-slate-700"></div>
                        <ol class="relative z-[1] grid grid-cols-3 gap-2">
                            <li data-step="0" class="stepper-item group flex items-center gap-3 cursor-default">
                                <div class="stepper-dot flex items-center justify-center h-8 w-8 rounded-full border border-slate-300 bg-white text-slate-600 group-[.is-active]:border-primary group-[.is-active]:text-primary group-[.is-complete]:bg-primary group-[.is-complete]:text-white">1</div>
                                <div class="hidden sm:block text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-300">Pilih Layanan</div>
                            </li>
                            <li data-step="1" class="stepper-item group flex items-center gap-3 justify-center cursor-default">
                                <div class="stepper-dot flex items-center justify-center h-8 w-8 rounded-full border border-slate-300 bg-white text-slate-600 group-[.is-active]:border-primary group-[.is-active]:text-primary group-[.is-complete]:bg-primary group-[.is-complete]:text-white">2</div>
                                <div class="hidden sm:block text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-300">Detail Pribadi</div>
                            </li>
                            <li data-step="2" class="stepper-item group flex items-center gap-3 justify-end cursor-default">
                                <div class="stepper-dot flex items-center justify-center h-8 w-8 rounded-full border border-slate-300 bg-white text-slate-600 group-[.is-active]:border-primary group-[.is-active]:text-primary group-[.is-complete]:bg-primary group-[.is-complete]:text-white">3</div>
                                <div class="hidden sm:block text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-300">Dokumen</div>
                            </li>
                        </ol>
                    </div>
                    <!-- Progress bar -->
                    <div class="w-full rounded-full bg-[#e7edf3] dark:bg-slate-700">
                        <div class="h-2 rounded-full bg-primary transition-all duration-300" id="progress-bar" style="width: 33%;"></div>
                    </div>
                    <!-- Tiny summary -->
                    <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-700/60"><span class="material-symbols-outlined text-[18px]">category</span><span id="selected-type-pill">Pembuatan Akta Kelahiran</span></span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-700/60"><span class="material-symbols-outlined text-[18px]">call</span><span id="summary-phone">{{ old('phone', auth()->check() ? (auth()->user()->phone ?? '—') : '—') }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Step 1: Pilih jenis surat (our allowed types) -->
            <section class="form-step" id="step-1">
                <h2 class="text-xl md:text-[22px] font-bold leading-tight tracking-[-0.015em] px-1">Pilih Jenis Surat yang Ingin Anda Ajukan</h2>
                <input type="hidden" name="type" id="type" value="{{ old('type','pembuatan_akta_kelahiran') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 md:p-6 border rounded-xl bg-white dark:bg-slate-800/50 dark:border-slate-700">
                    @php
                        $types = [
                            'pembuatan_akta_kelahiran' => ['label' => 'Pembuatan Akta Kelahiran', 'icon' => 'badge'],
                            'pembaruan_akta_kelahiran' => ['label' => 'Pembaruan Akta Kelahiran', 'icon' => 'contract_edit'],
                            'akta_nikah_islam' => ['label' => 'Akta Nikah (Islam)', 'icon' => 'diversity_1'],
                            'akta_nikah_non_islam' => ['label' => 'Akta Nikah (Non-Islam)', 'icon' => 'diversity_2'],
                            'akta_kematian' => ['label' => 'Akta Kematian', 'icon' => 'vital_signs'],
                        ];
                        $selected = old('type','pembuatan_akta_kelahiran');
                    @endphp
                    @foreach($types as $val=>$meta)
                        <button type="button" data-type="{{ $val }}" class="type-card flex flex-col gap-3 p-4 rounded-xl border {{ $selected===$val ? 'border-primary bg-primary/10' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 hover:border-primary dark:hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10' }} transition-all duration-200 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            <span class="material-symbols-outlined text-3xl text-primary">{{ $meta['icon'] }}</span>
                            <p class="text-base font-medium leading-normal">{{ $meta['label'] }}</p>
                        </button>
                    @endforeach
                </div>
            </section>

            <!-- Step 2: Data diri -->
            <section class="form-step hidden" id="step-2">
                <h2 class="text-xl md:text-[22px] font-bold leading-tight tracking-[-0.015em] px-1">Detail Pribadi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 md:p-6 border rounded-xl bg-white dark:bg-slate-800/50 dark:border-slate-700">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium leading-normal">NIK</label>
                        <input name="nik" type="text" maxlength="16" pattern="\d{16}" inputmode="numeric" placeholder="16 digit NIK" value="{{ old('nik', auth()->check() ? auth()->user()->nik : '') }}" class="h-10 px-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm">
                        <p class="text-xs text-slate-500">Jika kosong, sistem gunakan NIK dari akun Anda.</p>
                        @error('nik')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium leading-normal">Nama Lengkap</label>
                        <input name="nama" type="text" maxlength="191" placeholder="Nama lengkap" value="{{ old('nama', auth()->check() ? auth()->user()->name : '') }}" class="h-10 px-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm">
                        @error('nama')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2 flex flex-col gap-2">
                        <label class="text-sm font-medium leading-normal">Alamat</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap (jalan, RT/RW, desa/kelurahan)" class="min-h-[80px] px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2 flex flex-col gap-2">
                        <label class="text-sm font-medium leading-normal">Nomor Telepon / WhatsApp <span class="text-red-600">*</span></label>
                        <input id="phone" name="phone" type="tel" inputmode="tel" placeholder="0812xxxxxxx" value="{{ old('phone', auth()->check() ? (auth()->user()->phone ?? '') : '') }}" class="h-10 px-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm" @if(auth()->check() && auth()->user()->role === 'warga') required @endif>
                        <p id="phone-error" class="hidden text-sm text-red-600">Nomor telepon/WhatsApp wajib diisi.</p>
                        @error('phone')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Step 3: Dokumen -->
            <section class="form-step hidden" id="step-3">
                <h2 class="text-xl md:text-[22px] font-bold leading-tight tracking-[-0.015em] px-1">Unggah Dokumen Pendukung</h2>
                <div id="upload-dokumen" class="flex flex-col gap-4 p-4 md:p-6 border rounded-xl bg-white dark:bg-slate-800/50 dark:border-slate-700"></div>
            </section>

            <div class="flex justify-end gap-4 p-2 sticky bottom-0 bg-white/70 dark:bg-slate-900/60 backdrop-blur border-t border-slate-200 dark:border-slate-700 rounded-b-xl">
                <!-- Secondary button: soft slate/blue background, dark text -->
        <button type="button" id="prev-button"
            class="hidden min-w-[160px] items-center justify-center rounded-2xl h-12 px-6 bg-red-600 text-white font-bold hover:bg-red-700 ring-2 ring-red-500 border-2 border-white shadow-sm">
                    <span class="material-symbols-outlined mr-2">arrow_back</span>
                    <span>Sebelumnya</span>
                </button>

                <!-- Primary success button: green background, white text -->
        <button type="button" id="next-button"
            class="inline-flex min-w-[160px] items-center justify-center rounded-2xl h-12 px-6 bg-emerald-600 text-white font-bold hover:bg-emerald-700 ring-2 ring-emerald-500 border-2 border-white shadow-sm">
                    <span class="mr-2">Lanjutkan</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>

                <!-- Submit matches primary style -->
        <button type="submit" id="submit-button"
            class="hidden min-w-[160px] items-center justify-center rounded-2xl h-12 px-6 bg-emerald-600 text-white font-bold hover:bg-emerald-700 ring-2 ring-emerald-500 border-2 border-white shadow-sm">
                    <span class="mr-2">Ajukan Surat</span>
                    <span class="material-symbols-outlined">send</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formSteps = Array.from(document.querySelectorAll('.form-step'));
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = document.getElementById('progress-percentage');
            const currentStepText = document.getElementById('current-step-text');
            const prevButton = document.getElementById('prev-button');
            const nextButton = document.getElementById('next-button');
            const submitButton = document.getElementById('submit-button');
            const typeInput = document.getElementById('type');
            const uploadBox = document.getElementById('upload-dokumen');
            const typeCards = Array.from(document.querySelectorAll('.type-card'));
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');
            const stepperItems = Array.from(document.querySelectorAll('.stepper-item'));
            const selectedTypePill = document.getElementById('selected-type-pill');
            const summaryPhone = document.getElementById('summary-phone');

            const typeLabels = {
                'pembuatan_akta_kelahiran': 'Pembuatan Akta Kelahiran',
                'pembaruan_akta_kelahiran': 'Pembaruan Akta Kelahiran',
                'akta_nikah_islam': 'Akta Nikah (Islam)',
                'akta_nikah_non_islam': 'Akta Nikah (Non-Islam)',
                'akta_kematian': 'Akta Kematian',
            };

            const docsMeta = {
                'pembuatan_akta_kelahiran': [{ name: 'surat_kelahiran', label: 'Surat Kelahiran', required: true }],
                'pembaruan_akta_kelahiran': [{ name: 'akta_lama', label: 'Akta Kelahiran Lama', required: true }],
                'akta_nikah_islam': [{ name: 'buku_nikah', label: 'Buku Nikah', required: true }],
                'akta_nikah_non_islam': [{ name: 'akta_nikah', label: 'Akta Nikah', required: true }],
                'akta_kematian': [{ name: 'surat_keterangan_kematian', label: 'Surat Keterangan Kematian', required: true }],
            };

            const stepTitles = [
                'Pilih Layanan',
                'Detail Pribadi',
                'Unggah Dokumen Pendukung'
            ];

            let currentStep = 0; // 0..2

            function updateProgressBar() {
                const progress = ((currentStep + 1) / formSteps.length) * 100;
                progressBar.style.width = `${progress}%`;
                progressPercentage.textContent = `${Math.round(progress)}% Selesai`;
                currentStepText.textContent = `Langkah ${currentStep + 1} dari ${formSteps.length}: ${stepTitles[currentStep]}`;
                // Update stepper active/completed
                stepperItems.forEach((li, idx) => {
                    li.classList.toggle('is-active', idx === currentStep);
                    li.classList.toggle('is-complete', idx < currentStep);
                    const dot = li.querySelector('.stepper-dot');
                    if (dot) {
                        dot.classList.remove('border-primary','text-primary','bg-primary','text-white');
                        // reset base
                        dot.classList.add('border-slate-300','bg-white','text-slate-600');
                        if (idx === currentStep) {
                            dot.classList.remove('border-slate-300','text-slate-600');
                            dot.classList.add('border-primary','text-primary');
                        } else if (idx < currentStep) {
                            dot.classList.remove('border-slate-300','bg-white','text-slate-600');
                            dot.classList.add('bg-primary','text-white','border-primary');
                        }
                    }
                });
            }

            function showStep(index) {
                formSteps.forEach((el, i) => {
                    const isActive = i === index;
                    el.classList.toggle('hidden', !isActive);
                    el.dataset.active = isActive ? 'true' : 'false';
                });
                // toggle visibility + display mode for buttons
                const showPrev = index !== 0;
                prevButton.classList.toggle('hidden', !showPrev);
                prevButton.classList.toggle('inline-flex', showPrev);

                const showNext = index !== (formSteps.length - 1);
                nextButton.classList.toggle('hidden', !showNext);
                nextButton.classList.toggle('inline-flex', showNext);

                const showSubmit = index === (formSteps.length - 1);
                submitButton.classList.toggle('hidden', !showSubmit);
                submitButton.classList.toggle('inline-flex', showSubmit);
                // Guard: if on details step (1), disable next until phone is filled
                if (index === 1) {
                    applyPhoneGuard();
                } else {
                    clearPhoneError();
                    setNextEnabled(true);
                }
                updateProgressBar();
            }

            function isPhoneValid() {
                return !!(phoneInput && phoneInput.value && phoneInput.value.trim().length > 0);
            }

            function setNextEnabled(enabled) {
                nextButton.toggleAttribute('disabled', !enabled);
                nextButton.classList.toggle('opacity-50', !enabled);
                nextButton.classList.toggle('cursor-not-allowed', !enabled);
            }

            function showPhoneError() {
                if (phoneError) phoneError.classList.remove('hidden');
                if (phoneInput) phoneInput.classList.add('border-red-500','focus:ring-red-500');
            }

            function clearPhoneError() {
                if (phoneError) phoneError.classList.add('hidden');
                if (phoneInput) phoneInput.classList.remove('border-red-500','focus:ring-red-500');
            }

            function applyPhoneGuard() {
                const valid = isPhoneValid();
                setNextEnabled(valid);
                if (valid) clearPhoneError();
            }

            function buildDropZone(fieldName, label, required, ns) {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex flex-col gap-2';
                const id = `${ns}_${fieldName}`;
                wrapper.innerHTML = `
                    <label for="${id}" class="text-sm font-medium">${label} ${required ? "<span class='text-red-600'>*</span>" : ''}</label>
                    <div class="dz relative rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 bg-slate-50/70 dark:bg-slate-700/30 p-4 flex flex-col items-center justify-center text-center gap-2 hover:border-primary transition-colors">
                        <input id="${id}" type="file" name="documents[${ns}][${fieldName}]" ${required ? 'required' : ''} accept="image/*,application/pdf" class="sr-only">
                        <span class="material-symbols-outlined text-3xl text-slate-400">cloud_upload</span>
                        <p class="text-sm text-slate-600 dark:text-slate-300"><span class="dz-text">Tarik & letakkan file ke sini</span> atau <button type="button" class="dz-browse text-primary hover:underline">pilih dari perangkat</button></p>
                        <p class="text-xs text-slate-500">Format: JPG, PNG, PDF. Maks 5MB.</p>
                    </div>
                    <div class="dz-preview hidden mt-2 flex items-center gap-3 text-sm text-slate-700 dark:text-slate-200"></div>
                `;

                const dz = wrapper.querySelector('.dz');
                const input = wrapper.querySelector(`#${id}`);
                const browse = wrapper.querySelector('.dz-browse');
                const preview = wrapper.querySelector('.dz-preview');
                const dzText = wrapper.querySelector('.dz-text');

                function showPreview(file) {
                    preview.innerHTML = '';
                    if (!file) { preview.classList.add('hidden'); return; }
                    const info = document.createElement('div');
                    info.className = 'flex-1 min-w-0';
                    info.textContent = file.name;
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-300';
                    removeBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">close</span><span>Hapus</span>';
                    removeBtn.addEventListener('click', () => { input.value = ''; preview.classList.add('hidden'); dz.classList.remove('ring-2','ring-primary/40'); dzText.textContent = 'Tarik & letakkan file ke sini'; });
                    const icon = document.createElement('span');
                    icon.className = 'material-symbols-outlined text-[20px] text-slate-500';
                    icon.textContent = file.type.startsWith('image/') ? 'image' : 'description';
                    preview.appendChild(icon);
                    preview.appendChild(info);
                    preview.appendChild(removeBtn);
                    preview.classList.remove('hidden');
                }

                browse.addEventListener('click', function() { input.click(); });
                dz.addEventListener('click', function(e) { if (e.target === dz) input.click(); });
                dz.addEventListener('dragover', function(e) { e.preventDefault(); dz.classList.add('ring-2','ring-primary/40'); });
                dz.addEventListener('dragleave', function() { dz.classList.remove('ring-2','ring-primary/40'); });
                dz.addEventListener('drop', function(e) {
                    e.preventDefault();
                    dz.classList.remove('ring-2','ring-primary/40');
                    const file = e.dataTransfer.files?.[0];
                    if (file) { input.files = e.dataTransfer.files; showPreview(file); dzText.textContent = 'File dipilih'; }
                });
                input.addEventListener('change', function() { const file = input.files?.[0]; if (file) { showPreview(file); dzText.textContent = 'File dipilih'; } });

                return wrapper;
            }

            function renderUpload() {
                const type = typeInput.value;
                uploadBox.innerHTML = '';
                const list = docsMeta[type] || [];
                list.forEach(doc => {
                    const el = buildDropZone(doc.name, doc.label, !!doc.required, type);
                    uploadBox.appendChild(el);
                });
            }

            typeCards.forEach(btn => {
                btn.addEventListener('click', () => {
                    typeCards.forEach(b => b.classList.remove('border-primary','bg-primary/10'));
                    typeCards.forEach(b => b.classList.add('border-slate-200','dark:border-slate-700'));
                    btn.classList.add('border-primary','bg-primary/10');
                    btn.classList.remove('border-slate-200','dark:border-slate-700');
                    typeInput.value = btn.dataset.type;
                    if (selectedTypePill) selectedTypePill.textContent = typeLabels[typeInput.value] || '—';
                });
            });

            nextButton.addEventListener('click', () => {
                if (currentStep === 1 && !isPhoneValid()) {
                    showPhoneError();
                    applyPhoneGuard();
                    phoneInput?.focus();
                    return;
                }
                if (currentStep === 0) { renderUpload(); }
                if (currentStep < formSteps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
            prevButton.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Initialize view
            renderUpload();
            showStep(currentStep);
            // Initialize header pills
            if (selectedTypePill) { selectedTypePill.textContent = typeLabels[typeInput.value] || selectedTypePill.textContent; }

            // Live validation while typing phone
            if (phoneInput) {
                phoneInput.addEventListener('input', () => {
                    if (currentStep === 1) applyPhoneGuard();
                    if (summaryPhone) summaryPhone.textContent = phoneInput.value || '—';
                });
            }

            // Keyboard navigation: Enter => next, Shift+Enter => prev
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    // avoid submitting prematurely on non-last steps
                    if (currentStep < formSteps.length - 1) {
                        e.preventDefault();
                        nextButton.click();
                    }
                }
                if (e.key === 'Enter' && e.shiftKey) {
                    e.preventDefault();
                    if (currentStep > 0) prevButton.click();
                }
            });
        });
    </script>
    @endpush
</x-dashboard-layout>