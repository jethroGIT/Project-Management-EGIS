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
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- Ini untuk WP Number dan WP Name --}}

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
                        @foreach($activitiesForTable as $activity)
                            @php
                                $wpNumber = optional($activity->volume->workPackage)->wp_number ?? 'N/A';
                                $wpName = optional($activity->volume->workPackage)->name ?? 'N/A';
                                $volumeNum = optional($activity->volume)->volume_number ?? 'N/A';
                                $executionDate = optional($activity)->execution_date;
                            @endphp
                            <tr>
                                {{-- Data untuk Kolom Tersembunyi (digunakan oleh RowGroup) --}}
                                <td>{{ $wpNumber }} {{$wpName}}</td>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $volumeNum }}</td> {{-- Data Volume tampil di kolom ini --}}
                                <td>{{ \Carbon\Carbon::parse($executionDate)->format('d M Y') }}</td>
                                @foreach($users as $user)
                                    @php
                                        $userEntryForThisDateAndUser = $activitiesForTable->filter(function($entry) use ($activity, $user){
                                            return $entry->execution_date == $activity->execution_date && $entry->user_id == $user->user_id;
                                        })->first();
                                    @endphp
                                    <td>{{ $userEntryForThisDateAndUser->activity ?? '-' }}</td>
                                @endforeach
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm btn-edit-category" title="Edit Aktivitas Timesheet" 
                                                {{-- data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                                data-category-id="{{$wpCategory->category_id}}" 
                                                data-category-name="{{$wpCategory->name}}" --}}
                                        >
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm btn-delete-category" title="Hapus Aktivitas Timesheet" 
                                                {{-- data-category-id="{{$wpCategory->category_id}}" --}}
                                        >
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
                    {{-- dummy value user_id --}}
                    <input type="hidden" name="user_id" value="1" id="form_user_id">

                    <div class="form-group mb-6">
                        <label for="work_package_select" class="form-label fw-bold">Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="work_package_id" id="work_package_select" required>
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
                                        {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                        {{-- @foreach($workPackageVolumes as $volume)
                                            <option value="{{ $volume->volume_id }}">{{ $volume->volume_number }}</option>
                                        @endforeach --}}
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
                                <div class="card-header py-2"> {{-- Sesuaikan padding header --}}
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
                                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                                {{-- @foreach($users as $user)
                                                    <option value="{{ $user->user_id }}">{{ $user->name }} - {{$user->role->name}}</option>
                                                @endforeach --}}
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

@push('scripts')
<script>
     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
    });

    function initTabelTimesheet() {
        const table = $('#tabel_aktivitas').DataTable({
            "scrollY": '350px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false,
            "rowGroup": {
                // dataSrc bisa berupa array indeks kolom untuk multiple grouping levels
                dataSrc: [0], // Menggunakan kolom indeks 0 (WP Group Key) dan 1 (Volume Group Key)

                // Render header untuk setiap grup
                startRender: function (rows, group, level) {
                    return $('<tr/>')
                        .append('<td colspan="' + rows.columns()[0].length + '" class="bg-light text-dark fw-bold">' + group + '</td>')
                        .addClass('wp-group-header');                    
                }
            },
            // Kolom definisi: Sembunyikan kolom yang digunakan untuk grouping
            "columnDefs": [
                { "visible": false, "targets": [0] }, // Sembunyikan kolom WP Group Key (index 0) dan Volume Group Key (index 1)
            ]
        });

        setupActivitySearch(table);
    }

    function setupActivitySearch(table) {
        const searchInput = $('#searchActivity');

        // Search input handler
        searchInput.on('keyup change input', function() {
            const searchValue = this.value.trim();
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
    });

    // menampilkan volume berdasarkan work package yang dipilih
    const volumeData = @json($workPackages->mapWithKeys(function ($wp) {
        return [$wp->wp_id => $wp->workPackageVolumes->map(function ($vol) {
            return [
                'volume_id' => $vol->volume_id,
                'volume_number' => $vol->volume_number
            ];
        })];
    }));
    document.addEventListener('DOMContentLoaded', function () {
        const wpSelect = document.getElementById('work_package_select');
        const volumeSelect = document.getElementById('volume_select');

        wpSelect.addEventListener('change', function () {
            const wpId = this.value;
            const volumes = volumeData[wpId] || [];

            // Kosongkan isi volume
            volumeSelect.innerHTML = '<option value="">Pilih Volume</option>';

            // Tambahkan opsi baru
            volumes.forEach(vol => {
                const option = document.createElement('option');
                option.value = vol.volume_id;
                option.textContent = vol.volume_number;
                volumeSelect.appendChild(option);
            });
        });
    });

    // menampilkan personel berdasarkan volume yang dipilih
    // const personelData = @json($workPackages->flatMap(function ($wp) {
    //     return $wp->volumes->mapWithKeys(function ($volume) {
    //         return [
    //             $volume->volume_id => $volume->users->map(function ($user) {
    //                 return [
    //                     'user_id' => $user->user_id,
    //                     'name' => $user->name,
    //                     'role' => $user->role->name,
    //                 ];
    //             })
    //         ];
    //     });
    // }));
    // document.addEventListener('DOMContentLoaded', function () {
    //     const volumeSelect = document.getElementById('volume_select');
    //     const personelSelect = document.getElementById('personel_select_0');

    //     volumeSelect.addEventListener('change', function () {
    //         const volumeId = this.value;
    //         const personels = personelData[volumeId] || [];

    //         // Kosongkan dropdown personel
    //         personelSelect.innerHTML = '<option value="">Pilih Personel</option>';

    //         personels.forEach(personel => {
    //             const option = document.createElement('option');
    //             option.value = personel.user_id;
    //             option.textContent = `${personel.name} - ${personel.role}`;
    //             personelSelect.appendChild(option);
    //         });
    //     });
    // });
</script>
@endpush
