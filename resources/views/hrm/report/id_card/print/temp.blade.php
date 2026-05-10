{{-- ID_CARD_Process_Temp.rdf — Temporary card --}}
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;background:#fff;}
    .page{padding:10mm;}
    .card-grid{display:flex;flex-wrap:wrap;gap:6mm;}
    .id-card-temp{
        width:85mm;height:54mm;
        border:2px dashed #e8a020;border-radius:4mm;
        padding:3mm;background:#fffdf0;
        page-break-inside:avoid;position:relative;
        display:flex;flex-direction:column;gap:1.2mm;
    }
    .temp-badge{
        position:absolute;top:2mm;right:2mm;
        background:#e8a020;color:#fff;
        font-size:5.5pt;font-weight:700;padding:.5mm 2mm;border-radius:2mm;
    }
    .temp-header{font-size:6.5pt;font-weight:bold;color:#1a3a5c;margin-bottom:1mm;}
    .temp-row{font-size:5.5pt;display:flex;gap:1mm;}
    .temp-lbl{font-weight:bold;min-width:18mm;color:#555;}
    .temp-foot{font-size:5pt;color:#888;border-top:1px solid #e0c060;padding-top:1mm;margin-top:auto;}
    @media print{@page{size:A4;margin:8mm;}}
</style>
<div class="page"><div class="card-grid">
@foreach($employees as $emp)
@php
    $official   = $emp->getempofficial;
    $fullName   = trim($emp->first_name . ' ' . $emp->last_name);
    $expDate    = $official?->card_expire_date ? \Carbon\Carbon::parse($official->card_expire_date)->format('d/m/Y') : 'N/A';
@endphp
<div class="id-card-temp">
    <div class="temp-badge">TEMPORARY</div>
    <div class="temp-header">Four Design (Pvt.) Ltd.</div>
    <div class="temp-row"><span class="temp-lbl">Emp. No:</span> {{ $emp->empno }}</div>
    <div class="temp-row"><span class="temp-lbl">Name:</span> {{ $fullName }}</div>
    @if($emp->b_name)
    <div class="temp-row"><span class="temp-lbl"></span> {{ $emp->b_name }}</div>
    @endif
    @if($official?->designation)
    <div class="temp-row"><span class="temp-lbl">Designation:</span> {{ $official->designation }}</div>
    @endif
    @if($official?->section?->section_name)
    <div class="temp-row"><span class="temp-lbl">Section:</span> {{ $official->section->section_name }}</div>
    @endif
    <div class="temp-row">
        <span class="temp-lbl">Valid Until:</span>
        <span style="color:#c00;font-weight:bold">{{ $expDate }}</span>
    </div>
    <div class="temp-foot">This card is valid only until the date shown above. — HR Dept.</div>
</div>
@endforeach
</div></div>
