{{--
    ID_CARD_bangla_front.rdf  /  ID_CARD_bangla_level_knit.rdf
    Data source: HRM.EMP_PERSONAL + HRM.EMP_OFFICIAL
    Fields used:
        empno, first_name, last_name, b_name, blood_group, emp_pic / emp_img
        getempofficial->designation, designation_bangla, card_issue_date, card_expire_date
        locationBangla->bangla_address (if available)
--}}
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Kalpurush', 'SolaimanLipi', Arial, sans-serif;
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

    .id-card {
        width: 85mm;
        height: 54mm;
        border: 1.5px solid #1a3a5c;
        border-radius: 4mm;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #1a3a5c 0%, #2a5080 100%);
        color: #fff;
        display: flex;
        flex-direction: column;
        page-break-inside: avoid;
    }

    .card-top {
        background: #e8a020;
        color: #1a3a5c;
        text-align: center;
        padding: 1.5mm 2mm;
        font-size: 5.5pt;
        font-weight: 700;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    .card-body-inner {
        display: flex;
        flex: 1;
        padding: 2mm;
        gap: 2mm;
    }

    .card-photo img {
        width: 18mm;
        height: 23mm;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 2mm;
        background: rgba(255, 255, 255, .1);
    }

    .card-photo .no-photo {
        width: 18mm;
        height: 23mm;
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 2mm;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18pt;
        background: rgba(255, 255, 255, .1);
    }

    .card-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1.2mm;
    }

    .name-en {
        font-size: 7.5pt;
        font-weight: 700;
        line-height: 1.2;
    }

    .name-bn {
        font-size: 8pt;
        line-height: 1.3;
        color: #f0d080;
    }

    .info-row {
        font-size: 5.5pt;
        display: flex;
        gap: 1mm;
    }

    .info-lbl {
        opacity: .75;
        min-width: 14mm;
    }

    .info-val {
        font-weight: 600;
    }

    .card-foot {
        background: rgba(0, 0, 0, .25);
        padding: 1mm 2mm;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 5pt;
    }

    .blood {
        background: #dc3545;
        padding: .5mm 1.5mm;
        border-radius: 2mm;
        font-weight: 700;
        font-size: 6pt;
    }

    @media print {
        @page {
            size: A4;
            margin: 8mm;
        }

        .page {
            padding: 0;
        }
    }
</style>
<div class="page">
    <div class="card-grid">
        @foreach ($employees as $emp)
            @php
                $official = $emp->getempofficial;
                $fullNameEn = trim($emp->first_name . ' ' . $emp->last_name);
                $fullNameBn = $emp->b_name;
                $designation = $official?->designation ?? '';
                $designBn = $official?->designation_bangla ?? '';
                $sectionName = $official?->section?->section_name ?? '';
                $issueDate = $official?->card_issue_date
                    ? \Carbon\Carbon::parse($official->card_issue_date)->format('d/m/Y')
                    : '';
                $expireDate = $official?->card_expire_date
                    ? \Carbon\Carbon::parse($official->card_expire_date)->format('d/m/Y')
                    : '';
                $cardType = $official?->card_type ?? 'permanent';

                // Photo: prefer emp_pic, fallback emp_img
                $photoPath = $emp->emp_pic ?? ($emp->emp_img ?? null);
                $photoSrc = $photoPath ? asset($photoPath) : null;
            @endphp
            <div class="id-card">
                <div class="card-top">Four Design (Pvt.) Ltd. &mdash; Employee ID Card</div>
                <div class="card-body-inner">
                    <div class="card-photo">
                        @if ($photoSrc)
                            <img src="{{ $photoSrc }}" alt="photo">
                        @else
                            <div class="no-photo">👤</div>
                        @endif
                    </div>
                    <div class="card-info">
                        <div class="name-en">{{ $fullNameEn }}</div>
                        @if ($fullNameBn)
                            <div class="name-bn">{{ $fullNameBn }}</div>
                        @endif
                        <div class="info-row">
                            <span class="info-lbl">ID:</span>
                            <span class="info-val">{{ $emp->empno }}</span>
                        </div>
                        @if ($designation)
                            <div class="info-row">
                                <span class="info-lbl">Desig:</span>
                                <span class="info-val">{{ $designation }}</span>
                            </div>
                        @endif
                        @if ($designBn)
                            <div class="info-row">
                                <span class="info-val" style="font-size:6pt">{{ $designBn }}</span>
                            </div>
                        @endif
                        @if ($sectionName)
                            <div class="info-row">
                                <span class="info-lbl">Section:</span>
                                <span class="info-val">{{ $sectionName }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-foot">
                    <span>Issue: {{ $issueDate }}</span>
                    @if ($emp->blood_group)
                        <span class="blood">{{ $emp->blood_group }}</span>
                    @endif
                    <span>{{ $cardType === 'temporary' ? 'Exp: ' . $expireDate : 'Permanent' }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
