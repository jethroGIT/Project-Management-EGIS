@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Timesheet</h1>

    <!-- Card Activity -->
     <div class="card card-flush shadow-sm">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Activity Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Aktivitas
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchActivity">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchActivity" 
                        placeholder="Cari Aktivitas" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Activity Table -->
            <div class="table-responsive mb-2">
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="tabel_aktivitas">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping --}}
                            <th scope="col" style="width: 30px;">No</th>
                            <th scope="col" style="width: 30px;">Vol</th>
                            <th scope="col" style="width: 75px; min-width: 40px;">Tanggal</th>
                            @foreach($users as $user)
                                <th scope="col" style="width: 80px;">
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->role->name}}">{{$user->name}}</span>
                                </th>     
                            @endforeach
                            <th scope="col" style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @php $rowNumber = 1; @endphp
                        @foreach($groupedActivities as $groupKey => $group)
                            @php
                                $firstEntry = $group->first();
                                $wpNumber = optional($firstEntry->volume->workPackage)->wp_number ?? 'N/A';
                                $wpName = optional($firstEntry->volume->workPackage)->name ?? 'N/A';
                                $wpGroupKey = $wpNumber . ' - ' . $wpName;
                                $volumeNum = optional($firstEntry->volume)->volume_number ?? 'N/A';
                                $executionDate = optional($firstEntry)->execution_date;
                            @endphp

                            <tr>
                                {{-- Kolom tersembunyi untuk grouping --}}
                                <td style="display: none;">{{ $wpGroupKey }}</td>

                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $volumeNum }}</td>
                                <td>{{ \Carbon\Carbon::parse($executionDate)->format('d M Y') }}</td>
                                
                                @foreach($users as $user)
                                    @php
                                        $userEntry = $group->firstWhere('user_id', $user->user_id);
                                    @endphp
                                    <td>{{ $userEntry->activity ?? '-' }}</td>
                                @endforeach

                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit-activity" 
                                                title="Edit Aktivitas Timesheet" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editActivityModal"
                                                data-timesheet-id="{{$firstEntry->timesheet_id}}"
                                                data-volume-id="{{$firstEntry->volume_id}}"
                                                data-execution-date="{{$executionDate}}"
                                        >
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete-activity" title="Hapus Aktivitas Timesheet" data-timesheet-id="{{$firstEntry->timesheet_id}}">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </div>                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
@endsection

{{-- tambah aktivitas --}}
<div class="modal fade" tabindex="-1" id="addActivityModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-5">
                <h3 class="modal-title">Kelola Aktivitas Timesheet</h3>
            </div>
            <div class="modal-body py-3">
                <form id="addActivityForm" method="POST" action="{{route('timesheet.add')}}">
                    @csrf
                    @method('POST')

                    <div class="form-group mb-6">
                        <label for="work_package_select" class="form-label fw-bold">Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="wp_id" id="work_package_select" required>
                                <option value="">Pilih Work Package</option>
                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                @foreach($workPackages as $wp)
                                    <option value="{{ $wp->wp_id }}">{{ $wp->wp_number }} {{ $wp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="volume_select" class="form-label fw-bold">Volume</label>
                                <div class="input-group">
                                    <select class="form-select form-select-solid" name="volume_id" id="volume_select" required>
                                        <option value="">Pilih Volume</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="execution_date" placeholder="Masukkan Tanggal" min="1" max="31" required/>
                            </div>
                        </div>
                    </div>
                    <div id="personelActivityContainer">
                        <template id="personelActivityTemplate">
                            <div class="personel-activity-group card card-flush shadow-sm mb-6">
                                <div class="card-header py-2">{{--  Sesuaikan padding header --}}
                                    <h3 class="card-title fw-bold fs-5">Personel 1</h3>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-light-danger remove-personel-btn">
                                            <i class="bi bi-trash fs-5"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-6">
                                        <label for="personel_select_0" class="form-label fw-bold">Personel</label>
                                        <div class="input-group">
                                            <select class="form-select form-select-solid personel-select" name="personel_ids[]" id="personel_select_0" required>
                                                <option value="">Pilih Personel</option>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="form-group mb-6">
                                        <label for="activity_0" class="form-label fw-bold">Aktivitas</label>
                                        <textarea class="form-control activity-textarea"  name="activities[]" id="activity_0" rows="2" placeholder="Aktivitas" required></textarea>
                                    </div>                    
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="d-flex justify-content-start mb-0">
                        <button type="button" class="btn btn-primary" id="addPersonelActivityBtn">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Aktivitas Lain
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitAddActivityForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- edit dan/atau delete --}}
<div class="modal fade" tabindex="-1" id="editActivityModal" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-5">
                <h3 class="modal-title">Kelola Aktivitas Timesheet</h3>
            </div>
            <div class="modal-body py-3">
                <form id="editActivityForm" method="POST" action="{{route('timesheet.edit')}}">
                    @csrf
                    @method('POST')
                    {{-- hidden input --}}
                    <div id="edit_timesheet_ids_container"></div>
                    {{-- <input type="hidden" name="timesheet_id" id="edit_timesheet_id" value=""> --}}
                    <div class="form-group mb-6">
                        <label for="edit_work_package_select" class="form-label fw-bold">Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="wp_id" id="edit_work_package_select" required>
                                <option value="">Pilih Work Package</option>
                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                @foreach($workPackages as $wp)
                                    <option value="{{ $wp->wp_id }}">{{ $wp->wp_number }} {{ $wp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_volume_select" class="form-label fw-bold">Volume</label>
                                <div class="input-group">
                                    <select class="form-select form-select-solid" name="volume_id" id="edit_volume_select" required>
                                        <option value="">Pilih Volume</option>
                                    </select>
                                </div>
                            </div>
                            <div id="tanggal" class="col-md-6">
                                <label for="edit_execution_date" class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="edit_execution_date" required/>
                            </div>
                        </div>
                    </div>
                    <div id="editPersonelActivityContainer">
                    </div>
                    <div class="d-flex justify-content-start mb-0">
                        <button type="button" class="btn btn-primary" id="editPersonelActivityBtn">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Aktivitas Lain
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditActivityForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<template id="editPersonelActivityTemplate">
    <div class="personel-activity-group card card-flush shadow-sm mb-6">
        <div class="card-header py-2"> {{-- Sesuaikan padding header --}}
            <h3 class="card-title card-title-edit fw-bold fs-5">Personel 1</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger remove-edit-personel-btn">
                    <i class="bi bi-trash fs-5"></i> Hapus
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group mb-6">
                <label class="form-label fw-bold">Personel</label>
                <div class="input-group">
                    <select class="form-select form-select-solid edit-personel-select" name="personel_ids[]" id="personel_select_0" required>
                        <option value="">Pilih Personel</option>
                    </select>
                </div>
            </div> 
            <div class="form-group mb-6">
                <label class="form-label fw-bold">Aktivitas</label>
                <textarea class="form-control edit-activity-textarea"  name="activities[]" id="activity_0" rows="2" placeholder="Aktivitas" required></textarea>
            </div>                    
        </div>
    </div>
</template>

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel aktivitas
        initTableTimesheet();
    });

    function initTableTimesheet() {
        const table = $('#tabel_aktivitas').DataTable({
        scrollY: '350px',
        scrollX: true,
        fixedHeader: {
            header: true,
            headerOffset: 70
        },
        ordering: true,
        rowGroup: {
            dataSrc: 0,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="' + rows.columns()[0].length + '" class="bg-light text-dark fw-bold">' + group + '</td>')
                    .addClass('wp-group-header');
            }
        },
        columnDefs: [
            { targets: 0, visible: false, searchable: false }
        ]
    });
        setupActivitySearch(table);
    }

    function setupActivitySearch(table) {
        const searchInput = $('#searchActivity');

        // Search input handler
        searchInput.on('keyup change input', function() {
            const searchValue = this.value.trim();
            console.log('Search value:', searchValue);
            table.search(searchValue).draw();
        });

        // Clear button handler
        searchInput.on('search', function() {
            if (this.value === '') {
                table.search('').draw();
            }
        });

        // ESC key untuk clear search
        searchInput.on('keydown', function(e) {
            if (e.which === 27) { // ESC key
                e.preventDefault();
                this.value = '';
                $(this).trigger('input');
                this.focus();
            }
        });
    }

    // menampilkan volume berdasarkan work package yang dipilih
    const volumeData = @json(
        $workPackages->mapWithKeys(function ($wp) {
            return [$wp->wp_id => $wp->workPackageVolumes
                ->sortBy('volume_number')
                ->map(function ($vol) {
                    return [
                        'volume_id' => $vol->volume_id,
                        'volume_number' => $vol->volume_number
                    ];
            })->values()];
        })->toArray()
    );
    const volumeSelect = document.getElementById('volume_select');
    const editVolumeSelect = document.getElementById('edit_volume_select');

    document.addEventListener('DOMContentLoaded', function () {
        const wpSelect = document.getElementById('work_package_select');
        const editWpSelect = document.getElementById('edit_work_package_select');

        wpSelect.addEventListener('change', function () {
            updateVolumeOptions(this.value, volumeSelect);
            updateAllPersonelSelects('');
        });

        volumeSelect.addEventListener('change', function () {
            updateAllPersonelSelects(this.value);
        });

        editWpSelect.addEventListener('change', function () {
            updateVolumeOptions(this.value, editVolumeSelect);
            updateAllPersonelSelects('');
        });

        editVolumeSelect.addEventListener('change', function () {
            updateAllPersonelSelects(this.value);
        });
    });

    // menampilkan personel berdasarkan volume yang dipilih
    const personnelData = @json($personnelByVolume);

    function updateAllPersonelSelects(volumeId) {
        const selects = document.querySelectorAll('.personel-select, .edit-personel-select');
        const personnelList = personnelData[volumeId] || [];

        selects.forEach((select) => {
            // Simpan nilai terpilih sebelumnya (jika ada)
            const selectedValue = select.value;

            // Kosongkan dulu semua opsi
            select.innerHTML = '<option value="">Pilih Personel</option>';

            // Tambahkan opsi personel baru
            personnelList.forEach(person => {
                const option = document.createElement('option');
                option.value = person.user_id;
                option.textContent = `${person.name} - ${person.role}`;
                select.appendChild(option);
            });

            // Coba kembalikan nilai terpilih jika masih ada di list baru
            if (personnelList.find(p => p.user_id == selectedValue)) {
                select.value = selectedValue;
            }
        });
    }

    function updateVolumeOptions(wpId, volumeSelectElement) {
        const volumes = volumeData[wpId] || [];
        volumeSelectElement.innerHTML = '<option value="">Pilih Volume</option>';

        volumes.forEach(vol => {
            const option = document.createElement('option');
            option.value = vol.volume_id;
            option.textContent = vol.volume_number;
            volumeSelectElement.appendChild(option);
        });
    }

    // Add Personel Activity Button
    const addActivityModal = new bootstrap.Modal(document.getElementById('addActivityModal'));
    const addActivityForm = document.getElementById('addActivityForm');
    const submitAddActivityForm = document.getElementById('submitAddActivityForm');
    const personelActivityContainer = document.getElementById('personelActivityContainer');
    const personelActivityTemplate = document.getElementById('personelActivityTemplate');
    const addPersonelActivityBtn = document.getElementById('addPersonelActivityBtn');

    let currentPersonelGroups = 0;
    const maxPersonelGroups = {{ $users->count() }};

    function updatePersonelActivityButtons() {
        const totalGroups = personelActivityContainer.querySelectorAll('.personel-activity-group').length;
        currentPersonelGroups = totalGroups;

        // Nonaktifkan tombol tambah jika sudah mencapai batas maksimal user
        if (totalGroups >= maxPersonelGroups) {
            addPersonelActivityBtn.setAttribute('disabled', 'true');
        } else {
            addPersonelActivityBtn.removeAttribute('disabled');
        }
    }

    // menambah personel activity
    function addPersonelActivityGroup() {
        if (currentPersonelGroups >= maxPersonelGroups) {
            Swal.fire({
                text: "Anda telah mencapai batas maksimal personel (" + maxPersonelGroups + ").",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-warning" }
            });
            return;
        }

        const newGroup = personelActivityTemplate.content.cloneNode(true);
        const newGroupDiv = newGroup.querySelector('.personel-activity-group');
        const newGroupIndex = currentPersonelGroups; // Menggunakan counter sebagai indeks

        newGroupDiv.id = `personel-activity-${newGroupIndex}`; // Berikan ID unik ke grup div
        newGroupDiv.querySelector('.card-title').textContent = `Personel ${newGroupIndex + 1}`; // Update judul

        // Update ID dan name atribut untuk input select dan textarea
        const selectElement = newGroupDiv.querySelector('.personel-select');
        selectElement.id = `personel_select_${newGroupIndex}`;
        selectElement.name = `personel_ids[${newGroupIndex}]`; // Gunakan indeks untuk array name
        // selectElement.classList.add('personel-select');

        const textareaElement = newGroupDiv.querySelector('.activity-textarea');
        textareaElement.id = `activity_${newGroupIndex}`;
        textareaElement.name = `activities[${newGroupIndex}]`; // Gunakan indeks untuk array name

        // Update onclick untuk tombol hapus jika Anda menggunakan onclick
        const removeButton = newGroupDiv.querySelector('.remove-personel-btn');
        removeButton.onclick = function() {
            removePersonelActivityGroup(newGroupDiv.id);
        };

        personelActivityContainer.appendChild(newGroup);
        updatePersonelActivityButtons(); // Perbarui status tombol

        updateAllPersonelSelects(volumeSelect.value);
    }

    // menghapus personel activity
    function removePersonelActivityGroup(groupId) {
        const totalGroups = personelActivityContainer.querySelectorAll('.personel-activity-group').length;
        if (totalGroups <= 1) {
            Swal.fire({
                text: "Minimal harus ada 1 personel!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-warning" }
            });
            return;
        }
        
        document.getElementById(groupId).remove();
        updatePersonelActivityButtons();
        // Update nomor personel setelah penghapusan (Personel 1, Personel 2, dst)
        personelActivityContainer.querySelectorAll('.personel-activity-group').forEach((group, index) => {
            group.id = `personel-activity-${index}`;
            group.querySelector('.card-title').textContent = `Personel ${index + 1}`;
            group.querySelector('.personel-select').id = `personel_select_${index}`;
            group.querySelector('.personel-select').name = `personel_ids[${index}]`;
            group.querySelector('.activity-textarea').id = `activity_${index}`;
            group.querySelector('.activity-textarea').name = `activities[${index}]`;
            group.querySelector('.remove-personel-btn').onclick = function() {
                removePersonelActivityGroup(group.id);
            };
        });
    }

    // event listener untuk tombol tambah dan hapus personel activity
    if (addPersonelActivityBtn) {
        addPersonelActivityBtn.addEventListener('click', addPersonelActivityGroup);
    }

    // inisiasi awal dengan satu grup personel
    addActivityModal._element.addEventListener('show.bs.modal', function() {
        currentPersonelGroups = 0;
        // Hapus semua grup yang mungkin ada dari sesi sebelumnya
        personelActivityContainer.innerHTML = '';
        // Tambahkan satu grup personel secara default
        addPersonelActivityGroup();
        updateAllPersonelSelects(volumeSelect.value);
    });

    // Ketika modal ditutup, reset seluruh isian form
    $('#addActivityModal').on('hidden.bs.modal', function () {
        // Reset form
        document.getElementById('addActivityForm').reset();

        // Hapus semua personel card kecuali yang pertama
        const container = document.getElementById('personelActivityContainer');
        const groups = container.querySelectorAll('.personel-activity-group');
        groups.forEach((group, index) => {
            if (index > 0) group.remove();
        });

        // Reset ID dan name personel & aktivitas pertama
        const firstSelect = container.querySelector('.personel-select');
        const firstTextarea = container.querySelector('.activity-textarea');
        if (firstSelect) {
            firstSelect.id = 'personel_select_0';
            firstSelect.name = 'personel_ids[0]';
            firstSelect.innerHTML = '<option value="">Pilih Personel</option>';
        }
        if (firstTextarea) {
            firstTextarea.id = 'activity_0';
            firstTextarea.name = 'activities[0]';
            firstTextarea.value = '';
        }

        // Reset judul
        const title = container.querySelector('.card-title');
        if (title) title.textContent = 'Personel 1';

        // Reset dropdown volume
        const volumeSelect = document.getElementById('volume_select');
        if (volumeSelect) {
            volumeSelect.innerHTML = '<option value="">Pilih Volume</option>';
        }

        // Pastikan counter personel direset
        currentPersonelGroups = 1;
    });

    // Submit form untuk tambah aktivitas
    if (submitAddActivityForm) {
        submitAddActivityForm.addEventListener('click', function(e) {
            e.preventDefault();

            const formData = new FormData(addActivityForm);
            const url = addActivityForm.action;

            // Kirim permintaan AJAX
            fetch(url, {
                method: 'POST',
                body: formData, // FormData akan otomatis mengatur Content-Type: multipart/form-data
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Menandai ini adalah permintaan AJAX
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ambil CSRF token
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Jika respons bukan 2xx (misal 422 untuk validasi, 500 untuk error server)
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                    });
                }
                return response.json(); // Parse respons JSON
            })
            .then(data => {
                // Logika jika permintaan sukses
                Swal.fire({
                    text: data.message || "Data berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    addActivityModal.hide(); // Sembunyikan modal
                    location.reload(); // Reload halaman untuk melihat perubahan
                    // ATAU update UI tanpa reload:
                    // updateTableRow(data.data); // Panggil fungsi untuk update baris di tabel utama
                });
            })
            .catch(error => {
                // Logika jika ada error (jaringan, validasi, server error)
                console.error('Error updating resource:', error);
                Swal.fire({
                    text: error.message || "Terjadi kesalahan yang tidak terduga.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        });
    }

    // edit and or delete activity
    const editActivityModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
    const editActivityForm = document.getElementById('editActivityForm');
    const submitEditActivityForm = document.getElementById('submitEditActivityForm');
    const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
    const editPersonelActivityBtn = document.getElementById('editPersonelActivityBtn');
    
    let editCurrentPersonelGroups = 0;
    let editMaxPersonelGroups = {{ $users->count() }};

    function populateEditModal(timesheetId, volumeId, executionDate) {        
        // Set hidden input value for timesheet id
        const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
        hiddenInputContainer.innerHTML = '';

        // Fetch existing data
        fetch(`/timesheet-management/${volumeId}/${executionDate}/edit-data`)
            .then(response => response.json())
            .then(data => {
                const activities = data.data;
                console.log('Edit data:', activities);
                if (!activities.length || !activities[0].volume || !activities[0].volume.work_package) {
                    Swal.fire('Error', 'Data work package tidak tersedia.', 'error');
                    return;
                }
                const wpId = activities[0].volume.work_package.wp_id;

                document.getElementById('edit_work_package_select').value = wpId;

                const volumes = volumeData[wpId] || [];
                const volumeSelect = document.getElementById('edit_volume_select');
                volumeSelect.innerHTML = '<option value="">Pilih Volume</option>';
                volumes.forEach(vol => {
                    const option = document.createElement('option');
                    option.value = vol.volume_id;
                    option.textContent = vol.volume_number;
                    volumeSelect.appendChild(option);
                });

                volumeSelect.value = volumeId;
                document.getElementById('edit_execution_date').value = executionDate;

                // Kosongkan dulu container-nya
                const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
                hiddenInputContainer.innerHTML = '';

                // Tambahkan personel dan aktivitas yang sudah ada (dari database)
                activities.forEach((item, index) => {
                    if (item.timesheet_id) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'timesheet_ids[]';
                        hiddenInput.value = item.timesheet_id;
                        hiddenInputContainer.appendChild(hiddenInput);
                    }

                    // Tetap panggil function untuk render field-nya
                    editPersonelActivityGroup(item, index + 1);
                });

                // editPersonelActivityContainer.innerHTML = '';
                editCurrentPersonelGroups = 0;

                // Tambahkan isi template per aktivitas
                // activities.forEach((item, index) => {
                //     if (item.timesheet_id) {
                //         const hiddenInput = document.createElement('input');
                //         hiddenInput.type = 'hidden';
                //         hiddenInput.name = 'timesheet_ids[]';
                //         hiddenInput.value = item.timesheet_id;
                //         hiddenInputContainer.appendChild(hiddenInput);
                //     }
                //     editPersonelActivityGroup(item, index + 1); // Fungsi ini kamu perlu buat
                // });

                // menggantikan updateEditPersonelSelects(volumeId);
                updateAllPersonelSelects(volumeId);

                editActivityModal.show();
            })
            .catch(error => {
                console.error('Error loading edit data:', error);
                Swal.fire('Error', 'Gagal memuat data untuk edit', 'error');
            });
    }

    const allUsers = @json($users);
    function editPersonelActivityGroup(activity, number){
        // console.log('Adding/editing personel activity group:', activity, number);
        const template = document.getElementById('editPersonelActivityTemplate');
        if (!template) {
            console.error('Template editPersonelActivityTemplate not found');
            return;
        }
        const clone = template.content.cloneNode(true);
        
        const personelSelect = clone.querySelector('.edit-personel-select');
        const textarea = clone.querySelector('.edit-activity-textarea');
        const title = clone.querySelector('.card-title-edit');
        
        // Set title
        title.textContent = `Personel ${number}`;
        
        // Populate select
        allUsers.forEach(user => {
            const userOption = document.createElement('option');
            userOption.value = user.user_id;
            userOption.textContent = `${user.name} - ${user.role.name}`;
            personelSelect.appendChild(userOption);
        });

        textarea.value = activity.activity;
        personelSelect.value = String(activity.user_id);
        // Buat wrapper div untuk menyimpan clone dan memberi ID
        const wrapper = document.createElement('div');
        wrapper.classList.add('wrapper-edit-personel');
        wrapper.id = `edit-personel-activity-${editCurrentPersonelGroups}`;
        wrapper.appendChild(clone);

        // Pasang event listener pada tombol hapus
        const removeBtn = wrapper.querySelector('.remove-edit-personel-btn');
        if (!removeBtn) {
            console.error('remove-edit-personel-btn not found in clone');
        } else {
            removeBtn.addEventListener('click', function () {
                removeEditPersonelActivityGroup(wrapper.id);
            });
        }
        editPersonelActivityContainer.appendChild(wrapper);
        editCurrentPersonelGroups++;

        wrapper.querySelector('.remove-edit-personel-btn').addEventListener('click', function() {
            removeEditPersonelActivityGroup(wrapper.id);
        });
    }

    function removeEditPersonelActivityGroup(groupId) {
        const totalGroups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group').length;
        if (totalGroups <= 1) {
            Swal.fire({
                title: "Hapus Seluruh Aktivitas?",
                text: `Apakah Anda yakin ingin menghapus seluruh aktivitas personel?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger me-2",
                    cancelButton: "btn btn-secondary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
            const timesheetId = document.getElementById('edit_timesheet_id').value; // atau ambil dari global variable

            fetch(`/timesheet-management/${timesheetId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title:'Berhasil!', 
                        text: data.message, 
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    }).then(() => {
                        // Tutup modal dan update UI
                        $('#editActivityModal').modal('hide');
                        $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
                        // console.log('Menghapus seluruh aktivitas personel');
                        document.getElementById(groupId).remove();
                        editCurrentPersonelGroups--;
                        // Tetap update numbering (meskipun 0, jaga konsistensi DOM)
                        updateEditGroupNumbering();
                    });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
            });
                }
            });
        }else {
            Swal.fire({
                title: "Hapus Aktivitas?",
                text: `Apakah Anda yakin ingin menghapus aktivitas personel?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger me-2",
                    cancelButton: "btn btn-secondary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(groupId).remove();
                    editCurrentPersonelGroups--;
                    // Tetap update numbering (meskipun 0, jaga konsistensi DOM)
                    updateEditGroupNumbering();
                }
            });
        }
    }

    function updateEditGroupNumbering() {
        editPersonelActivityContainer.querySelectorAll('.personel-activity-group').forEach((group, index) => {
            group.id = `edit-personel-activity-${index}`;
            group.querySelector('.card-title').textContent = `Personel ${index + 1}`;
        });
    }

    // Event listener for edit buttons
    $(document).on('click', '.btn-edit-activity', function(e) {
        e.preventDefault();
        const timesheetId = $(this).data('timesheet-id');
        const volumeId = $(this).data('volume-id');
        const executionDate = $(this).data('execution-date');
        populateEditModal(timesheetId, volumeId, executionDate);
    });

    if (editPersonelActivityBtn) {
        editPersonelActivityBtn.addEventListener('click', () => editPersonelActivityGroup());
    }

    if (submitEditActivityForm) {
        submitEditActivityForm.addEventListener('click', function(e) {
            e.preventDefault();
            
            const formData = new FormData(editActivityForm);
            const url = editActivityForm.action;
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    text: data.message || "Data berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    editActivityModal.hide();
                    location.reload();
                });
            })
            .catch(error => {
                console.error('Error updating resource:', error);
                Swal.fire({
                    text: error.message || "Terjadi kesalahan yang tidak terduga.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        });
    }

    // delete
    $(document).on('click', '.btn-delete-activity', function(e) {
        e.preventDefault();
        const timesheetId = $(this).data('timesheet-id');

        Swal.fire({
            title: 'Yakin ingin menghapus seluruh aktivitas personel pada tanggal ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/timesheet-management/${timesheetId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title:'Berhasil!', 
                            text: data.message, 
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            // location.reload(); // atau remove baris dari DOM langsung
                            $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
                        });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                });
            }
        });
    });
</script>
@endpush
