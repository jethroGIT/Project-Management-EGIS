function populateEditModal(timesheetIds, volumeIds, executionDate) {
    // Set hidden input value for timesheet IDs
    const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
    hiddenInputContainer.innerHTML = '';

    // Tambahkan hidden input untuk setiap timesheet_id
    timesheetIds.forEach(timesheetId => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'timesheet_ids[]';
        hiddenInput.value = timesheetId;
        hiddenInputContainer.appendChild(hiddenInput);
    });

    // Fetch existing data untuk semua volume dan tanggal
    fetch(`/timesheet-management/${volumeIds.join(',')}/${executionDate}/edit-data`)
        .then(response => response.json())
        .then(data => {
            if (!data.success || !data.data.length) {
                Swal.fire('Error', 'Data tidak ditemukan untuk volume dan tanggal yang dipilih.', 'error');
                return;
            }

            const activities = data.data;
            console.log('Edit data:', activities);

            // Ambil WP ID dari data pertama
            const wpId = activities[0].volume.work_package.wp_id;

            // Set Work Package dan Volume
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

            // Set volume yang dipilih
            volumeIds.forEach(volumeId => {
                const option = volumeSelect.querySelector(`option[value="${volumeId}"]`);
                if (option) option.selected = true;
            });

            // Set tanggal eksekusi
            document.getElementById('edit_execution_date').value = executionDate;

            // Kosongkan container personel activity
            editPersonelActivityContainer.innerHTML = '';

            // Tambahkan personel dan aktivitas yang sudah ada
            activities.forEach(activity => {
                editPersonelActivityGroup(activity);
            });

            // Update personel select options
            updateAllPersonelSelects(volumeIds[0]); // Gunakan volume pertama untuk update
            updateEditPersonelSelectOptions();

            // Panggil updateMandaysInfo untuk setiap personel yang sudah ada
            const personelSelects = editPersonelActivityContainer.querySelectorAll('.edit-personel-select');
            personelSelects.forEach(select => {
                updateMandaysInfo(select, volumeIds[0]); // Gunakan volume pertama untuk update
            });

            // Tampilkan modal edit
            editActivityModal.show();
        })
        .catch(error => {
            console.error('Error loading edit data:', error);
            Swal.fire('Error', 'Gagal memuat data untuk edit', 'error');
        });
}

function populateEditModal(timesheetIds, volumeIds, executionDate) {
    // Set hidden input value for timesheet IDs
    const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
    hiddenInputContainer.innerHTML = '';

    // Tambahkan hidden input untuk setiap timesheet_id
    timesheetIds.forEach(timesheetId => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'timesheet_ids[]';
        hiddenInput.value = timesheetId;
        hiddenInputContainer.appendChild(hiddenInput);
    });

    // Fetch existing data untuk semua volume dan tanggal
    fetch(`/timesheet-management/${volumeIds.join(',')}/${executionDate}/edit-data`)
        .then(response => response.json())
        .then(data => {
            if (!data.success || !data.data.length) {
                Swal.fire('Error', 'Data tidak ditemukan untuk volume dan tanggal yang dipilih.', 'error');
                return;
            }

            const activities = data.data;

            // Ambil WP ID dari data pertama
            const wpId = activities[0].volume.work_package.wp_id;

            // Set Work Package dan Volume
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

            // Set volume yang dipilih
            volumeIds.forEach(volumeId => {
                const option = volumeSelect.querySelector(`option[value="${volumeId}"]`);
                if (option) option.selected = true;
            });

            // Set tanggal eksekusi
            document.getElementById('edit_execution_date').value = executionDate;

            // Kosongkan container personel activity
            editPersonelActivityContainer.innerHTML = '';

            // Tambahkan personel dan aktivitas yang sudah ada
            activities.forEach(activity => {
                editPersonelActivityGroup(activity);
            });

            // Update personel select options
            updateAllPersonelSelects(volumeIds[0]); // Gunakan volume pertama untuk update
            updateEditPersonelSelectOptions();

            // Panggil updateMandaysInfo untuk setiap personel yang sudah ada
            const personelSelects = editPersonelActivityContainer.querySelectorAll('.edit-personel-select');
            personelSelects.forEach(select => {
                updateMandaysInfo(select, volumeIds[0]); // Gunakan volume pertama untuk update
            });

            // Tampilkan modal edit
            editActivityModal.show();
        })
        .catch(error => {
            console.error('Error loading edit data:', error);
            Swal.fire('Error', 'Gagal memuat data untuk edit', 'error');
        });
}

$(document).on('click', '.btn-edit-activity', function(e) {
    e.preventDefault();

    // Ambil data dari tombol Edit
    const timesheetIds = $(this).data('timesheet-ids');
    const volumeIds = $(this).data('volume-ids');
    const executionDate = $(this).data('execution-dates');

    // Panggil fungsi untuk memuat data ke modal edit
    populateEditModal(timesheetIds, volumeIds, executionDate);
});

function editPersonelActivityGroup(activity) {
    const template = document.getElementById('editPersonelActivityTemplate');
    if (!template) {
        console.error('Template editPersonelActivityTemplate not found');
        return;
    }

    // Clone template
    const group = template.content.cloneNode(true).querySelector('.personel-activity-group');

    const personelSelect = group.querySelector('.edit-personel-select');
    const durationSelect = group.querySelector('.edit-duration-select');
    const textarea = group.querySelector('.edit-activity-textarea');
    const removeBtn = group.querySelector('.remove-edit-personel-btn');

    // Populate select
    allUsers.forEach(user => {
        const userOption = document.createElement('option');
        userOption.value = user.user_id;
        let roleName = (user.roles && user.roles.length > 1)
            ? user.roles[1].name
            : (user.roles && user.roles.length ? user.roles[0].name : '');
        userOption.textContent = `${user.name} - ${roleName}`;
        personelSelect.appendChild(userOption);
    });

    // Set data dari aktivitas
    durationSelect.value = activity.duration ? String(activity.duration) : '1.0';
    textarea.value = activity.activity || '';
    personelSelect.value = activity.user_id ? String(activity.user_id) : '';

    // Tambahkan timesheet_id ke tombol hapus
    if (removeBtn) {
        removeBtn.setAttribute('data-timesheet-id', activity.timesheet_id); // Inject timesheet_id
        removeBtn.addEventListener('click', function () {
            removeEditPersonelActivityGroup(group);
        });
    }

    editPersonelActivityContainer.appendChild(group);
    updateEditGroupNumbering();
}

function validateEditActivityForm() {
    // Cek field utama
    const wp = document.getElementById('edit_work_package_select').value.trim();
    const vol = document.getElementById('edit_volume_select').value.trim();
    const date = document.getElementById('edit_execution_date').value.trim();

    if (!wp || !vol || !date) {
        Swal.fire({
            title: "Data Belum Lengkap",
            text: "Kategori Work Package, Volume, dan Tanggal wajib diisi.",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: { confirmButton: "btn btn-primary" }
        });
        return false;
    }

    // Cek setiap grup personel
    const personelSelects = document.querySelectorAll('.edit-personel-select');
    const activityTextareas = document.querySelectorAll('.edit-activity-textarea');
    for (let i = 0; i < personelSelects.length; i++) {
        if (!personelSelects[i].value.trim() || !activityTextareas[i].value.trim()) {
            Swal.fire({
                title: "Data Belum Lengkap",
                text: "Personel, durasi, dan aktivitas wajib diisi untuk setiap grup.",
                icon: "info",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-primary" }
            });
            return false;
        }
    }

    return true;
}

if (submitEditActivityForm) {
    submitEditActivityForm.addEventListener('click', function(e) {
        e.preventDefault();

        if (!validateEditActivityForm()) { return; }

        const deletedTimesheetInput = document.getElementById('deleted_timesheet_ids');
        if (deletedTimesheetInput) {
            deletedTimesheetInput.value = JSON.stringify(deletedTimesheetIds);
        }

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
                title: "Berhasil",
                text: "Data berhasil diperbarui!",
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