{{-- ID_CARD_bangla_back.rdf — Back side --}}
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #fff;
    }

    .page {
        padding: 10mm;
    }

    .card-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 5mm;
    }

    .id-card-back {
        width: 85mm;
        height: 54mm;
        border: 1.5px solid #1a3a5c;
        border-radius: 4mm;
        background: #f8f8f8;
        padding: 3mm;
        page-break-inside: avoid;
        display: flex;
        flex-direction: column;
        gap: 1.5mm;
    }

    .back-title {
        font-size: 7pt;
        font-weight: bold;
        text-align: center;
        color: #1a3a5c;
        border-bottom: 1px solid #ccc;
        padding-bottom: 1mm;
    }

    .back-row {
        display: flex;
        font-size: 5.5pt;
        gap: 1mm;
    }

    .back-lbl {
        font-weight: bold;
        color: #555;
        min-width: 22mm;
    }

    .back-val {
        color: #222;
    }

    .barcode {
        text-align: center;
        margin-top: auto;
        font-size: 5pt;
        color: #888;
        border-top: 1px dashed #ccc;
        padding-top: 1.5mm;
    }

    @media print {
        @page {
            size: A4;
            margin: 8mm;
        }
    }
</style>
<div class="page">
    <div class="card-grid">
        @foreach ($employees as $emp)
            @php
                $official = $emp->getempofficial;
                $fullName = trim($emp->first_name . ' ' . $emp->last_name);
                $dept = $official?->dept_name ?? ($official?->department ?? '');
                $section = $official?->section?->section_name ?? '';
                $mobile = $emp->emp_mobile_no ?? '';
            @endphp
            <div class="id-card-back">
                <div class="back-title">Four Design (Pvt.) Ltd. &mdash; Bangladesh</div>
                <div class="back-row"><span class="back-lbl">Emp. No:</span><span
                        class="back-val">{{ $emp->empno }}</span></div>
                <div class="back-row"><span class="back-lbl">Name:</span><span class="back-val">{{ $fullName }}</span>
                </div>
                @if ($emp->b_name)
                    <div class="back-row"><span class="back-lbl"></span><span
                            class="back-val">{{ $emp->b_name }}</span></div>
                @endif
                @if ($dept)
                    <div class="back-row"><span class="back-lbl">Department:</span><span
                            class="back-val">{{ $dept }}</span></div>
                @endif
                @if ($section)
                    <div class="back-row"><span class="back-lbl">Section:</span><span
                            class="back-val">{{ $section }}</span></div>
                @endif
                @if ($mobile)
                    <div class="back-row"><span class="back-lbl">Mobile:</span><span
                            class="back-val">{{ $mobile }}</span></div>
                @endif
                @if ($emp->blood_group)
                    <div class="back-row"><span class="back-lbl">Blood Group:</span><span class="back-val"
                            style="color:#c00;font-weight:bold">{{ $emp->blood_group }}</span></div>
                @endif
                <div class="barcode">||| {{ $emp->empno }} |||| — If found, return to HR Dept.</div>
            </div>
        @endforeach
    </div>
</div>
