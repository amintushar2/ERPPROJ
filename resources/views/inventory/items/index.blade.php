@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h4 class="fw-bold m-0">Item Master</h4>

    <div class="d-flex gap-2">
        <input id="search" class="form-control form-control-sm" placeholder="Search all data...">

        <button class="btn btn-primary btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#itemModal">
            <i class="fas fa-plus"></i> Add Item
        </button>
    </div>
</div>

<!-- TABLE -->
<table class="table table-hover table-bordered">
<thead class="table-light">
<tr>
    <th>Name</th>
    <th>Category</th>
    <th>Unit</th>
    <th>Credit</th>
    <th>Balance</th>
    <th></th>
</tr>
</thead>
<tbody id="table"></tbody>
</table>

<!-- PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-2">
    <button id="prev" class="btn btn-sm btn-secondary">Prev</button>
    <span id="pageInfo"></span>
    <button id="next" class="btn btn-sm btn-secondary">Next</button>
</div>

</div>

<!-- MODAL -->
<div class="modal fade" id="itemModal">
<div class="modal-dialog">
<form id="form">
<div class="modal-content">

<div class="modal-header">
<h5>Item</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" id="id">

<input id="item_name" class="form-control mb-2" placeholder="Item Name">

<select id="category_id" class="form-control mb-2"></select>

<select id="unit_id" class="form-control mb-2"></select>

<input id="credit_limit" type="number" class="form-control mb-2" placeholder="Credit Limit">

<input id="present_balance" type="number" class="form-control mb-2" placeholder="Balance">

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary btn-sm">Save</button>
</div>

</div>
</form>
</div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let currentPage = 1;
let searchValue = '';
let timer;

// 🔥 LOAD DATA
function load(page = 1){

fetch(`/inventory/items/data?page=${page}&search=${searchValue}`)
.then(r=>r.json())
.then(res=>{

let html='';

res.data.forEach(i=>{
html+=`
<tr>
<td>${i.item_name}</td>
<td>${i.category_name}</td>
<td>${i.unit_name}</td>
<td>${i.credit_limit}</td>
<td>${i.present_balance}</td>
<td>

<button class="btn btn-sm btn-primary edit"
data-id="${i.item_id}"
data-name="${i.item_name}"
data-category="${i.category_id}"
data-unit="${i.unit_id}"
data-credit="${i.credit_limit}"
data-balance="${i.present_balance}">
Edit</button>

<button class="btn btn-sm btn-danger del"
data-id="${i.item_id}">
Delete</button>

</td>
</tr>`;
});

table.innerHTML = html;

// PAGINATION
currentPage = res.current_page;

pageInfo.innerText = `Page ${res.current_page} of ${res.last_page}`;

prev.disabled = res.current_page === 1;
next.disabled = res.current_page === res.last_page;

});
}

// 🔥 LOAD CATEGORY
fetch('/inventory/items/categories')
.then(r=>r.json())
.then(d=>{
let opt='';
d.forEach(c=>{
opt+=`<option value="${c.category_id}">${c.category_name}</option>`;
});
category_id.innerHTML = opt;
});

// 🔥 LOAD UNIT
fetch('/inventory/items/units')
.then(r=>r.json())
.then(d=>{
let opt='';
d.forEach(u=>{
opt+=`<option value="${u.unit_id}">${u.unit_name}</option>`;
});
unit_id.innerHTML = opt;
});

// 🔥 SAVE
form.onsubmit = e=>{
e.preventDefault();

let idVal = id.value;
let url = idVal 
    ? `/inventory/items/update/${idVal}` 
    : `/inventory/items/store`;

fetch(url,{
method:'POST',
headers:{
'Content-Type':'application/json',
'X-CSRF-TOKEN':'{{ csrf_token() }}'
},
body:JSON.stringify({
item_name:item_name.value,
category_id:category_id.value,
unit_id:unit_id.value,
credit_limit:credit_limit.value,
present_balance:present_balance.value
})
})
.then(()=>{
bootstrap.Modal.getInstance(itemModal).hide();

Swal.fire({
icon:'success',
title:'Saved',
timer:1200,
showConfirmButton:false
});

load(currentPage);
form.reset();
});
};

// 🔥 EDIT
document.addEventListener('click',e=>{
if(e.target.classList.contains('edit')){
id.value = e.target.dataset.id;
item_name.value = e.target.dataset.name;
category_id.value = e.target.dataset.category;
unit_id.value = e.target.dataset.unit;
credit_limit.value = e.target.dataset.credit;
present_balance.value = e.target.dataset.balance;

new bootstrap.Modal(itemModal).show();
}
});

// 🔥 DELETE
document.addEventListener('click',e=>{
if(e.target.classList.contains('del')){

Swal.fire({
title:'Delete item?',
icon:'warning',
showCancelButton:true
}).then(res=>{
if(res.isConfirmed){
fetch(`/inventory/items/delete/${e.target.dataset.id}`)
.then(()=> load(currentPage));
}
});
}
});

// 🔥 PAGINATION
prev.onclick = () => {
if(currentPage > 1) load(currentPage - 1);
};

next.onclick = () => {
load(currentPage + 1);
};

// 🔥 SERVER SEARCH (DEBOUNCE)
search.onkeyup = function(){

clearTimeout(timer);

timer = setTimeout(()=>{
searchValue = this.value;
load(1);
}, 400);

};

// INIT
load();

</script>

@endpush


<script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>