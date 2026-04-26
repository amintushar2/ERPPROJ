{{-- resources/views/hrm/tabs/tab_nominee.blade.php --}}
<div class="page-heading"><i class="bi bi-people-fill"></i> Nominee / Family</div>
<form id="frmNominee">@csrf<input type="hidden" name="empno" value="{{ $empno }}">
    <div class="sec-card">
        <div class="sec-card-head"><i class="bi bi-person-plus"></i> Add Nominee Record</div>
        <div class="sec-card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Name (EN):</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="depd_name"
                                placeholder="Full Name in English"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Name (BN):</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="depent_name_bangla"
                                placeholder="বাংলায় নাম" style="font-family:SutonnyMJ,sans-serif;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Relation (EN):</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="relationship"
                                placeholder="e.g. Wife, Son"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Relation (BN):</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="relation_bn"
                                style="font-family:SutonnyMJ,sans-serif;" placeholder="সম্পর্ক"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Date of Birth:</label>
                        <div class="col-sm-8"><input type="text" class="form-control date-pick" name="d_dob"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Age:</label>
                        <div class="col-sm-8"><input type="number" class="form-control" name="d_age"
                                placeholder="Age"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Gender:</label>
                        <div class="col-sm-8 pt-2">
                            <div class="form-check form-check-inline"><input type="radio" class="form-check-input"
                                    name="d_sex" value="male" id="nmM"><label class="form-check-label"
                                    for="nmM">Male</label></div>
                            <div class="form-check form-check-inline"><input type="radio" class="form-check-input"
                                    name="d_sex" value="female" id="nmF"><label class="form-check-label"
                                    for="nmF">Female</label></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">As On:</label>
                        <div class="col-sm-8"><input type="text" class="form-control date-pick" name="d_as_on"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Percentage:</label>
                        <div class="col-sm-8"><input type="number" class="form-control" name="percentage"
                                placeholder="%" max="100"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Address (EN):</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address" placeholder="Address in English"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Address (BN):</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address_bn" style="font-family:SutonnyMJ,sans-serif;"
                                placeholder="বাংলায় ঠিকানা"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="action-bar">
        <button class="btn btn-save" type="submit"><i class="bi bi-plus-circle me-1"></i> Add</button>
        <button class="btn btn-clr" type="reset"><i class="bi bi-x-circle me-1"></i> Clear</button>
    </div>
</form>
<div class="sub-table-wrap">
    <table class="emp-table">
        <thead>
            <tr>
                <th>Empno</th>
                <th>Name</th>
                <th>Name BN</th>
                <th>Relation</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Gender</th>
                <th>%</th>
                <th>Address</th>
                <th style="width:70px;">Action</th>
            </tr>
        </thead>
        <tbody id="tbl_nom"></tbody>
    </table>
</div>
<script>
    $(function() {
        loadNomRows();

        $('#frmNominee').on('submit', function(e) {
            e.preventDefault();

            const fd = {};
            $(this).serializeArray().forEach(f => fd[f.name] = f.value);
            fd.d_sex = $('input[name="d_sex"]:checked').val();
            fd.empno = fd.empno || $('#frmNominee [name="empno"]').val();

            $.ajax({
                url: '/api/saveEmpFamily',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(fd),
                dataType: 'json',
                success: res => {
                    swalOk(res.message);
                    loadNomRows();
                    $('#frmNominee')[0].reset();
                },
                error: swalErr
            });
        });
    });

    function loadNomRows() {
        const empno = $('#frmNominee [name="empno"]').val();
        if (!empno) return;

        $.get("{{ URL::to('getNome') }}" + '/' + empno, function(d) {
            $('#tbl_nom').html(d);
        });

        setTimeout(function() {
            if (window.initDatePick) initDatePick(document);
        }, 50);
    }

    /* ── Smart dd-mm-yyyy date picker for all .date-pick inputs ── */
    (function() {
        function initDatePick(scope) {
            var scope = scope || document;
            scope.querySelectorAll('input.date-pick').forEach(function(el) {
                if (el.dataset.fpInit) return;
                el.dataset.fpInit = '1';

                if (typeof flatpickr !== 'undefined') {
                    flatpickr(el, {
                        dateFormat: 'd-m-Y',
                        allowInput: true,
                        disableMobile: true,
                        onReady: function(_, __, fp) {
                            fp.calendarContainer && fp.calendarContainer.classList.add('fp-sm');
                        }
                    });
                }

                el.addEventListener('keydown', function(e) {
                    if (e.key === 'Tab' || e.key === 'Enter') {
                        autoFormatDate(this);
                    }
                });
                el.addEventListener('blur', function() {
                    autoFormatDate(this);
                });
            });
        }

        function autoFormatDate(el) {
            var raw = el.value.replace(/\D/g, '');
            if (!raw) return;

            var day, mon, yr;
            if (raw.length === 6) {
                day = raw.substr(0, 2);
                mon = raw.substr(2, 2);
                yr = raw.substr(4, 2);
                yr = (parseInt(yr, 10) <= 30 ? '20' : '19') + yr;
            } else if (raw.length === 8) {
                day = raw.substr(0, 2);
                mon = raw.substr(2, 2);
                yr = raw.substr(4, 4);
            } else {
                return;
            }

            var d = parseInt(day, 10),
                m = parseInt(mon, 10),
                y = parseInt(yr, 10);
            if (d < 1 || d > 31 || m < 1 || m > 12 || y < 1900 || y > 2099) return;

            var formatted = day + '-' + mon + '-' + yr;
            el.value = formatted;
            if (el._flatpickr) el._flatpickr.setDate(formatted, false, 'd-m-Y');
        }

        document.addEventListener('DOMContentLoaded', function() {
            initDatePick(document);
        });

        window.initDatePick = initDatePick;
    })();
</script>
