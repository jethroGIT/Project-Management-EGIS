@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Finance Performance</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <a href="{{route('work-package.detail', $volume_id)}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-0 mt-1">WP {{ $workPackage->workPack_number }} {{ $workPackage->name }}</h2>
            </div>
            <div class="row mt-8 align-items-center justify-content-between" style="height: 50px; padding: 0px 0px;">
                <div class="col-md-4 d-flex align-items-center" style="height: 40px">
                    <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                        <span class="fw-bold">WP Value</span>
                        <i class="bi bi-info-circle text-primary ms-2"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="sum(Biaya by YoY)">
                        </i>
                    </div>
                    <div class="border h-100 d-flex align-items-center justify-content-center w-100">
                        <span class="text">{{ number_format($totalByYoy, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-light-primary btn-edit-finance" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_financial">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                        Edit Data
                    </button>
                </div>                    
            </div> 
            <div class="table-responsive mt-5">
                {{-- @if($activities->isNotEmpty()) --}}
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                    <thead class="border border-1 border-secondary bg-light fs-5">
                        <tr class="border-bottom border-1 border-secondary">
                            <th scope="col" rowspan="2" class="text-center align-middle border-end border-start border-secondary fw-bold py-0" style="width: 160px">Jabatan</th>
                            <th scope="col" rowspan="2" class="text-center align-middle border-end border-start border-secondary fw-bold py-0">JTK</th>
                            <th scope="col" colspan="2" class="text-center align-middle border-end border-secondary fw-bold py-2">Mandays (JHK)</th>
                            <th scope="col" colspan="4" class="text-center align-middle border-start border-secondary fw-bold py-2">Biaya</th>
                        </tr>
                        <tr>
                            <th class="text-center fw-bold">Rencana</th>
                            <th class="text-center fw-bold">Realisasi</th>                            
                            <th class="text-center fw-bold">Tenaga Kerja</th>                            
                            <th class="text-center fw-bold">By YoY
                                <i class="bi bi-info-circle text-primary ms-2"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Mandays Rencana x Biaya Tenaga Kerja">
                                </i>
                            </th>
                            <th class="text-center fw-bold">Realisasi
                                <i class="bi bi-info-circle text-primary ms-2"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Mandays Realisasi x Biaya Tenaga Kerja">
                                </i>
                            </th>
                            <th class="text-center fw-bold">Sisa
                                <i class="bi bi-info-circle text-primary ms-2"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Biaya by YoY - Realisasi">
                                </i>
                            </th>
                        </tr>
                    </thead> 
                    <tbody class="border-bottom border-3 border-secondary fs-5">
                        @foreach($costsPerRole as $cost)
                            <tr>
                                <td class="text-start align-middle">{{ $cost['role_name'] }}</td>
                                <td class="text-center align-middle">{{ $cost['jtk'] }}</td>
                                <td class="text-center align-middle">{{ $cost['jhk'] }}</td>
                                <td class="text-center align-middle">{{ $cost['timesheet_count'] }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['resourceCost'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['by_yoy'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['realization_cost'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">
                                    <span class="{{$cost['remaining_cost'] < 0 ? 'badge badge-danger' : ''}}">
                                        {{ number_format($cost['remaining_cost'], 0, ',', '.') }}
                                    </span>
                                </td>               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold fs-6">
                        <tr>
                            <td colspan="5" class="text-start">Total Keuangan</td>
                            <td class="text-center">{{ number_format($totalRealization, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-start">Biaya Overtime</td>
                            <td class="text-center">{{ number_format($overtimeCost, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-start">Persentase</td>
                            <td class="text-center">
                                <span class="{{$realizationPercentage > 100 ? 'badge badge-danger' : ''}}">
                                    {{ number_format($realizationPercentage, 2)}}%
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                {{-- @else
                    <p>Tidak ada data Timesheet</p>
                @endif --}}
            </div>
        </div>
    </div>
</div>
@endsection

{{-- edit finance --}}
<div class="modal fade" tabindex="-1" id="kt_modal_edit_financial">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Finansial</h3>
            </div>
            <div class="modal-body pb-2">
                <form method="POST" action="{{route('performance-finance.edit')}}" id="editFinanceForm">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="category_id" id="form_category_id">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label fw-bolder">Jabatan</label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bolder">Biaya Tenaga Kerja</label>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        @foreach($costsPerRole as $cost)
                            <div class="col-md-5 mb-5">
                                <label class="form-label">{{$cost['role_name']}}</label>
                            </div>
                            <div class="col-md-7 mb-5">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" 
                                            name="resourceCost[{{ $cost['role_id'] }}]" 
                                            id="editResCost_{{ $cost['role_id'] }}" 
                                            class="form-control" placeholder="0" 
                                            value="{{ number_format($cost['resourceCost'], 0, ',', '.') }}"
                                            data-original="{{ number_format($cost['resourceCost'], 0, ',', '.') }}"
                                            required
                                    />
                                    <input type="hidden"
                                        name="resourceCost[{{ $cost['role_id'] }}]"
                                        id="editResCostHidden_{{ $cost['role_id'] }}"
                                        value="{{ number_format($cost['resourceCost'], 2, '.', '') }}"
                                    />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditFinanceForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('[id^=editResCost_]').each(function() {
            setupEditCurrencyFormatting($(this));
        });

        $('#kt_modal_edit_financial').on('show.bs.modal', function () {
            $('[id^=editResCost_]').each(function() {
                const original = $(this).data('original');
                $(this).val(original);
            });
        });
    });

    function setupEditCurrencyFormatting(costInput) {
        costInput.on('input', function() {
            let value = $(this).val().replace(/[^\d]/g, ''); // Hapus semua kecuali angka
            let numericValue = value ? parseInt(value, 10) : 0;
            $(this).val(numericValue ? numericValue.toLocaleString('id-ID') : '');

            // Update hidden field with numeric value (as string, with 2 decimals)
            let roleId = $(this).attr('id').replace('editResCost_', '');
            $('#editResCostHidden_' + roleId).val(numericValue.toFixed(2));
        });
        
        // Handle paste event
        costInput.on('paste', function(e) {
            const self = this;
            setTimeout(() => {
                let value = $(self).val().replace(/[^\d]/g, '');
                let numericValue = value ? parseInt(value, 10) : 0;
                $(self).val(numericValue ? numericValue.toLocaleString('id-ID') : '');

                let roleId = $(self).attr('id').replace('editResCost_', '');
                $('#editResCostHidden_' + roleId).val(numericValue.toFixed(2));
            }, 10);
        });
    }

    const submitEditFinanceForm = document.getElementById('submitEditFinanceForm');
    const editFinanceForm = document.getElementById('editFinanceForm');
    const editFinanceModal = new bootstrap.Modal(document.getElementById('kt_modal_edit_financial'));

    document.addEventListener('DOMContentLoaded', function(e) {
        submitEditFinanceForm.addEventListener('click', function() {
            e.preventDefault();

            // Validasi jika ada input lebih dari 15 digit
            let isValid = true;
            let isChanged = false;
            $('[id^=editResCost_]').each(function() {
                let value = $(this).val().replace(/[^\d]/g, ''); // Hapus semua kecuali angka
                let originalValue = $(this).data('original').replace(/[^\d]/g, '');

                if (value.length > 13) { // 15 digit termasuk desimal
                    isValid = false;
                    Swal.fire({
                        text: "Nominal biaya tenaga kerja tidak boleh lebih dari 15 digit termasuk desimal. Silakan periksa kembali.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                    return false; // Hentikan iterasi jika ditemukan input tidak valid
                }

                if (value !== originalValue) {
                    isChanged = true;
                }
            });

            if (!isValid) return;

            if (!isChanged) {
                Swal.fire({
                    text: "Tidak ada perubahan pada biaya tenaga kerja.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Batal",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                return;
            }

            Swal.fire({
                text: "Perubahan biaya tenaga kerja akan diterapkan ke semua Work Package.",
                icon: "warning",
                buttonsStyling: false,
                cancelButtonText: "Batal",
                confirmButtonText: "Lanjutkan",
                showCancelButton: true,
                customClass: { cancelButton: "btn btn-secondary", confirmButton: "btn btn-warning" }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Lanjutkan", kirim data ke server
                    const formData = new FormData(editFinanceForm);
                    const url = editFinanceForm.action;

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
                            text: data.message || "Data berhasil diubah!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            editFinanceModal.hide();
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error adding category:', error);
                        Swal.fire({
                            text: error.message || "Terjadi kesalahan yang tidak terduga.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: { confirmButton: "btn btn-danger" }
                        });
                    });
                }
            });
        });
    });
</script>
@endpush

