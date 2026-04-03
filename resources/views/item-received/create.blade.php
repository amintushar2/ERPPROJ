@php
    $master     = null;
    $formAction = route('item-received.store');
    $formMethod = 'POST';
    $pageTitle  = 'New GRN – Item Received Entry';
@endphp

@include('item-received._form')
