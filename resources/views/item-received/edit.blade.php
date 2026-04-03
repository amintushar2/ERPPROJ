@php
    $formAction = route('item-received.update', $master->received_no_id);
    $formMethod = 'PUT';
    $pageTitle  = 'Edit GRN ' . $master->RECEIVED_NO . ' – Item Received Entry';
@endphp

@include('item-received._form')
