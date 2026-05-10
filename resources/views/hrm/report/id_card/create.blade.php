@extends('layouts.id_card')
@section('title', isset($employee) ? 'Edit Employee' : 'New Employee')

@section('idc_content')
<div class="card card-module">
    <div class="card-header card-header-module d-flex align-items-center gap-2">
        <i class="bi bi-person-plus"></i>
        {{ isset($employee) ? 'Edit Employee: ' . $employee->emp_no : 'New Employee ID Card Record' }}
        <a href="{{ route('id-card.index') }}" class="btn btn-sm btn-outline-light ms-auto">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">

        <form id="empForm"
              action="{{ isset($employee) ? route('id-card.update', $employee) : route('id-card.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($employee)) @method('PUT') @endif

            {{-- ── SECTION 1: Employee Info ── --}}
            <div class="section-title"><i class="bi bi-person"></i> Employee Information</div>
            <div class="row g-3 mb-3">

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Employee No <span class="text-danger">*</span></label>
                    <input type="text" name="emp_no" class="form-control form-control-sm"
                           value="{{ old('emp_no', $employee->emp_no ?? '') }}"
                           {{ isset($employee) ? 'readonly' : '' }} required>
                </div>

                <div class="col-md-4">
                    <label class="form-label form-label-sm fw-semibold">Name (English) <span class="text-danger">*</span></label>
                    <input type="text" name="emp_name" class="form-control form-control-sm"
                           value="{{ old('emp_name', $employee->emp_name ?? '') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label form-label-sm fw-semibold">Name (Bangla)</label>
                    <input type="text" name="emp_name_bangla" class="form-control form-control-sm"
                           value="{{ old('emp_name_bangla', $employee->emp_name_bangla ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Blood Group</label>
                    <select name="blood_group" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group', $employee->blood_group ?? '') == $bg ? 'selected' : '' }}>
                                {{ $bg }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- ── SECTION 2: Designation / Department / Section ── --}}
            <div class="section-title"><i class="bi bi-briefcase"></i> Designation & Department</div>
            <div class="row g-3 mb-3">

                <div class="col-md-4">
                    <label class="form-label form-label-sm fw-semibold">Designation (English)</label>
                    <input type="text" name="designation" class="form-control form-control-sm"
                           value="{{ old('designation', $employee->designation ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label form-label-sm fw-semibold">Designation (Bangla)</label>
                    <input type="text" name="designation_bangla" class="form-control form-control-sm"
                           value="{{ old('designation_bangla', $employee->designation_bangla ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label form-label-sm fw-semibold">Department</label>
                    <input type="text" name="department" class="form-control form-control-sm"
                           value="{{ old('department', $employee->department ?? '') }}">
                </div>

                <div class="col-md-4">
                    {{-- LOV: SELECT SECTION_NO, SECTION_NAME FROM SECTION --}}
                    <label class="form-label form-label-sm fw-semibold">Section</label>
                    <select name="section_id" class="form-select form-select-sm select2"
                            data-placeholder="-- Select Section --">
                        <option value="">-- Select Section --</option>
                        @foreach($sections as $sec)
                            <option value="{{ $sec->id }}"
                                {{ old('section_id', $employee->section_id ?? '') == $sec->id ? 'selected' : '' }}>
                                {{ $sec->section_no }} – {{ $sec->section_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label form-label-sm fw-semibold">Mobile</label>
                    <input type="text" name="mobile" class="form-control form-control-sm"
                           value="{{ old('mobile', $employee->mobile ?? '') }}">
                </div>

                <div class="col-md-5">
                    <label class="form-label form-label-sm fw-semibold">Address</label>
                    <input type="text" name="address" class="form-control form-control-sm"
                           value="{{ old('address', $employee->address ?? '') }}">
                </div>

            </div>

            {{-- ── SECTION 3: Card Details ── --}}
            <div class="section-title"><i class="bi bi-credit-card"></i> Card Details</div>
            <div class="row g-3 mb-3">

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Card Type <span class="text-danger">*</span></label>
                    <select name="card_type" class="form-select form-select-sm" required>
                        <option value="permanent" {{ old('card_type', $employee->card_type ?? 'permanent') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="temporary" {{ old('card_type', $employee->card_type ?? '') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                        <option value="process"   {{ old('card_type', $employee->card_type ?? '') == 'process'   ? 'selected' : '' }}>Process</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Card Status <span class="text-danger">*</span></label>
                    <select name="card_status" class="form-select form-select-sm" required>
                        <option value="active"   {{ old('card_status', $employee->card_status ?? 'active') == 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('card_status', $employee->card_status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Join Date</label>
                    <input type="date" name="join_date" class="form-control form-control-sm"
                           value="{{ old('join_date', isset($employee) ? $employee->join_date?->format('Y-m-d') : '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Card Issue Date</label>
                    <input type="date" name="card_issue_date" class="form-control form-control-sm"
                           value="{{ old('card_issue_date', isset($employee) ? $employee->card_issue_date?->format('Y-m-d') : '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label form-label-sm fw-semibold">Card Expire Date</label>
                    <input type="date" name="card_expire_date" class="form-control form-control-sm"
                           value="{{ old('card_expire_date', isset($employee) ? $employee->card_expire_date?->format('Y-m-d') : '') }}">
                </div>

            </div>

            {{-- ── SECTION 4: Photo ── --}}
            <div class="section-title"><i class="bi bi-camera"></i> Employee Photo</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4 d-flex align-items-start gap-3">
                    <img id="photoPreview"
                         src="{{ isset($employee) && $employee->photo_path ? asset($employee->photo_path) : asset('images/default_photo.png') }}"
                         class="photo-preview" alt="Photo">
                    <div>
                        <label class="form-label form-label-sm fw-semibold">Upload Photo</label>
                        <input type="file" name="photo" id="photoInput" class="form-control form-control-sm"
                               accept="image/*">
                        <small class="text-muted">JPG/PNG, max 2MB. Recommended: 120×150px</small>
                    </div>
                </div>
            </div>

            {{-- ── Buttons ── --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="btnSave">
                    <i class="bi bi-save"></i> {{ isset($employee) ? 'Update' : 'Save' }}
                </button>
                <a href="{{ route('id-card.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                @if(isset($employee))
                <button type="button" class="btn btn-danger ms-auto btn-delete-form"
                        data-id="{{ $employee->id }}" data-name="{{ $employee->emp_name }}">
                    <i class="bi bi-trash"></i> Delete
                </button>
                @endif
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // Select2
    $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

    // Live photo preview
    $('#photoInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => $('#photoPreview').attr('src', e.target.result);
        reader.readAsDataURL(file);
    });

    // Form submit via AJAX
    $('#empForm').on('submit', function (e) {
        e.preventDefault();
        const btn  = $('#btnSave');
        const form = new FormData(this);

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        $.ajax({
            url:         $(this).attr('action'),
            type:        $(this).attr('method') === 'post' ? 'POST' : 'POST', // FormData always POST
            data:        form,
            processData: false,
            contentType: false,
            success(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text:  res.message,
                        timer: 1800,
                        showConfirmButton: false,
                    }).then(() => window.location = '{{ route("id-card.index") }}');
                } else {
                    Swal.fire('Error', res.message ?? 'Unknown error.', 'error');
                }
            },
            error(xhr) {
                const errors = xhr.responseJSON?.errors;
                let msg = 'Validation failed.';
                if (errors) msg = Object.values(errors).flat().join('<br>');
                Swal.fire({ icon: 'error', title: 'Error', html: msg });
                btn.prop('disabled', false).html('<i class="bi bi-save"></i> {{ isset($employee) ? "Update" : "Save" }}');
            }
        });
    });

    // Delete from edit page
    $(document).on('click', '.btn-delete-form', function () {
        const id   = $(this).data('id');
        const name = $(this).data('name');
        Swal.fire({
            title: 'Delete?',
            html:  `Delete <b>${name}</b>? This cannot be undone.`,
            icon:  'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, Delete',
        }).then(result => {
            if (!result.isConfirmed) return;
            $.ajax({
                url:  `/id-card/${id}`,
                type: 'DELETE',
                success(res) {
                    if (res.success) {
                        Swal.fire('Deleted', res.message, 'success')
                            .then(() => window.location = '{{ route("id-card.index") }}');
                    }
                }
            });
        });
    });
});
</script>
@endpush
