{{-- emp_lebel.rdf / ID_CARD_Process_lebel.rdf — Label stickers --}}
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;background:#fff;}
    .page{padding:8mm;}
    .label-grid{display:flex;flex-wrap:wrap;gap:3mm;}
    .label{
        width:62mm;height:28mm;
        border:1px solid #999;border-radius:2mm;
        padding:2mm 3mm;background:#fff;
        page-break-inside:avoid;
        display:flex;flex-direction:column;justify-content:center;gap:1mm;
    }
    .lbl-co{font-size:5pt;font-weight:bold;color:#1a3a5c;border-bottom:1px solid #ddd;padding-bottom:.5mm;margin-bottom:.5mm;}
    .lbl-no{font-size:6pt;font-weight:700;color:#333;}
    .lbl-name{font-size:5.5pt;color:#111;}
    .lbl-desg{font-size:5pt;color:#555;}
    .lbl-sec{font-size:5pt;color:#777;}
    @media print{@page{size:A4;margin:6mm;}}
</style>
<div class="page"><div class="label-grid">
@foreach($employees as $emp)
@php
    $official  = $emp->getempofficial;
    $fullName  = trim($emp->first_name . ' ' . $emp->last_name);
@endphp
<div class="label">
    <div class="lbl-co">Four Design (Pvt.) Ltd.</div>
    <div class="lbl-no">{{ $emp->empno }}</div>
    <div class="lbl-name">{{ $fullName }}</div>
    @if($emp->b_name)
    <div class="lbl-name">{{ $emp->b_name }}</div>
    @endif
    @if($official?->designation)
    <div class="lbl-desg">{{ $official->designation }}</div>
    @endif
    @if($official?->section?->section_name)
    <div class="lbl-sec">{{ $official->section->section_name }}</div>
    @endif
</div>
@endforeach
</div></div>
