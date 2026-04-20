{{-- resources/views/hrm/tabs/tab_experience.blade.php --}}
<div class="page-heading"><i class="bi bi-buildings-fill"></i> Experience</div>
<form id="frmExp">@csrf<input type="hidden" name="empno" value="{{ $empno }}">
    <div class="sec-card">
        <div class="sec-card-head"><i class="bi bi-briefcase-fill"></i> Add Experience Record</div>
        <div class="sec-card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Organization:</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="organization"
                                placeholder="Organization Name"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Prev Emp ID:</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="prv_emp_no"
                                placeholder="Previous Employee ID"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Designation:</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="designation"
                                placeholder="Designation"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Address:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="org_address" placeholder="Organization Address"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Tel No:</label>
                        <div class="col-sm-8"><input type="tel" class="form-control" name="org_tel"
                                placeholder="Telephone"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Last Salary:</label>
                        <div class="col-sm-8"><input type="number" class="form-control" name="last_sal_drawn"
                                placeholder="Amount"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">From:</label>
                        <div class="col-sm-8"><input type="text" class="form-control date-pick" name="d_from"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">To:</label>
                        <div class="col-sm-8"><input type="text" class="form-control date-pick" name="d_to"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Total Years:</label>
                        <div class="col-sm-8"><input type="number" class="form-control" name="total_years"
                                placeholder="Years"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row p-1"><label class="col-sm-4 col-form-label">Leave Reason:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="leave_reason" placeholder="Reason for leaving"></textarea>
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
                <th>Organization</th>
                <th>Designation</th>
                <th>From</th>
                <th>To</th>
                <th>Years</th>
                <th>Last Salary</th>
                <th style="width:70px;">Action</th>
            </tr>
        </thead>
        <tbody id="tbl_exp"></tbody>
    </table>
</div>
<script>
    $(function() {
        loadExpRows();
        $('#frmExp').on('submit', function(e) {
            e.preventDefault();
            const fd = {};
            $(this).serializeArray().forEach(f => fd[f.name] = f.value);
            fd.empno = fd.empno || getEmpno();
            $.ajax({
                url: '/api/saveEmpWorkExp',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(fd),
                dataType: 'json',
                success: res => {
                    swalOk(res.message);
                    loadExpRows();
                    $('#frmExp')[0].reset();
                },
                error: swalErr
            });
        });
    });

    function loadExpRows() {
        $.get("{{ URL::to('empExper') }
            setTimeout(function() {
                if (window.initDatePick) initDatePick(document);
            }, 50);
        }
        /"+getEmpno(),d=>$('#tbl_exp').html(d)); }


        /* ── Smart dd-mm-yyyy date picker for all .date-pick inputs ── */
        (function() {
            function initDatePick(scope) {
                var scope = scope || document;
                scope.querySelectorAll('input.date-pick').forEach(function(el) {
                    if (el.dataset.fpInit) return; // skip if already init
                    el.dataset.fpInit = '1';

                    // 1. Flatpickr calendar
                    if (typeof flatpickr !== 'undefined') {
                        flatpickr(el, {
                            dateFormat: 'd-m-Y',
                            allowInput: true,
                            disableMobile: true,
                            onReady: function(_, __, fp) {
                                fp.calendarContainer && fp.calendarContainer.classList.add(
                                    'fp-sm');
                            }
                        });
                    }

                    // 2. Smart 6/8-digit auto-format on keyup
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
                var raw = el.value.replace(/\D/g, ''); // digits only
                if (!raw) return;

                var day, mon, yr;

                if (raw.length === 6) {
                    // 020496 → 02-04-1996
                    day = raw.substr(0, 2);
                    mon = raw.substr(2, 2);
                    yr = raw.substr(4, 2);
                    yr = (parseInt(yr, 10) <= 30 ? '20' : '19') + yr;
                } else if (raw.length === 8) {
                    // 02041996 → 02-04-1996
                    day = raw.substr(0, 2);
                    mon = raw.substr(2, 2);
                    yr = raw.substr(4, 4);
                } else {
                    return; // don't reformat partial or already-formatted
                }

                // Validate range
                var d = parseInt(day, 10),
                    m = parseInt(mon, 10),
                    y = parseInt(yr, 10);
                if (d < 1 || d > 31 || m < 1 || m > 12 || y < 1900 || y > 2099) return;

                var formatted = day + '-' + mon + '-' + yr;
                el.value = formatted;

                // Push value into Flatpickr instance if present
                if (el._flatpickr) el._flatpickr.setDate(formatted, false, 'd-m-Y');
            }

            // Init on DOMContentLoaded (for empform Tab1)
            document.addEventListener('DOMContentLoaded', function() {
                initDatePick(document);
            });

            // Expose for lazy-loaded AJAX tabs
            window.initDatePick = initDatePick;
        })();
</script>
