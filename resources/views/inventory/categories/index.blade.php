@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

<!-- HEADER -->
<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Category</h4>

    <div class="d-flex gap-2">
        <input id="search" class="form-control form-control-sm" placeholder="Search...">

        <button class="btn btn-primary btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#catModal">
    + Add Category
</button>
    </div>
</div>

<!-- TABLE -->
<table class="table table-hover table-bordered">
<thead class="table-light">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Group</th>
    <th></th>
</tr>
</thead>

<tbody id="table"></tbody>
</table>

</div>

<!-- MODAL -->
<div class="modal fade" id="catModal">
<div class="modal-dialog">
<form id="form">
<div class="modal-content">

<div class="modal-header">
<h5>Category</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" id="id">

<input id="category_name" class="form-control mb-2" placeholder="Category Name">

<select id="inv_group_id" class="form-control mb-2"></select>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-primary btn-sm">Save</button>
</div>

</div>
</form>
</div>
</div>

@endsection

@push('scripts')

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

// LOAD CATEGORY
function load(){
fetch('/inventory/categories/data')
.then(r=>r.json())
.then(d=>{
let html='';
d.forEach(i=>{
html+=`
<tr>
<td>${i.category_id}</td>
<td>${i.category_name}</td>
<td>${i.group_name}</td>
<td>

<button class="btn btn-sm btn-primary edit"
data-id="${i.category_id}"
data-name="${i.category_name}"
data-group="${i.inv_group_id}">
Edit</button>

<button class="btn btn-sm btn-danger del"
data-id="${i.category_id}">
Delete</button>

</td>
</tr>`;
});
table.innerHTML=html;
});
}

// LOAD GROUP DROPDOWN
function loadGroups(){
fetch('/inventory/groups/list')
.then(r=>r.json())
.then(d=>{
let opt='<option value="">Select Group</option>';
d.forEach(g=>{
opt+=`<option value="${g.inv_group_id}">${g.inv_group_name}</option>`;
});
inv_group_id.innerHTML=opt;
});
}

// SAVE
form.onsubmit = function(e){
e.preventDefault();

let idVal = id.value;
let url = idVal 
    ? `/inventory/categories/update/${idVal}` 
    : `/inventory/categories/store`;

fetch(url,{
method:'POST',
headers:{
'Content-Type':'application/json',
'X-CSRF-TOKEN':'{{ csrf_token() }}'
},
body:JSON.stringify({
category_name:category_name.value.trim(),
inv_group_id:inv_group_id.value
})
})
.then(()=>{
bootstrap.Modal.getInstance(catModal).hide();

Swal.fire({
icon:'success',
title:'Saved',
timer:1200,
showConfirmButton:false
});

load();
form.reset();
});
};

// EDIT
document.addEventListener('click',function(e){
if(e.target.classList.contains('edit')){

id.value = e.target.dataset.id;
category_name.value = e.target.dataset.name;
inv_group_id.value = e.target.dataset.group;

new bootstrap.Modal(catModal).show();
}
});

// DELETE
document.addEventListener('click',function(e){
if(e.target.classList.contains('del')){

let id = e.target.dataset.id;

Swal.fire({
title:'Delete this category?',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33'
}).then(res=>{
if(res.isConfirmed){

fetch(`/inventory/categories/delete/${id}`)
.then(()=>{
Swal.fire({
icon:'success',
title:'Deleted',
timer:1200,
showConfirmButton:false
});
load();
});
}
});
}
});

// SEARCH
search.onkeyup = function(){
let v = this.value.toLowerCase();
document.querySelectorAll('#table tr').forEach(r=>{
r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
});
};

// RESET MODAL
document.getElementById('catModal').addEventListener('hidden.bs.modal', function(){
form.reset();
id.value = '';
});

// INIT
load();
loadGroups();

});

</script>

@endpush

<script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>