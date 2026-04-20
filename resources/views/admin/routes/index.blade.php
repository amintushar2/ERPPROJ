@extends('layouts.app')
@section('title', 'Route Entry')
@section('page-title', 'Route Entry')
@section('breadcrumb')
    <li class="breadcrumb-item active">Route Entry</li>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-plus-circle me-2"></i>Add Route</div>
                <div class="card-body">
                    <form action="{{ route('routes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Route ID <span class="text-danger">*</span></label>
                            <input type="text" name="ROUTE_ID"
                                class="form-control @error('ROUTE_ID') is-invalid @enderror" value="{{ old('route_id') }}"
                                maxlength="30" placeholder="e.g. HRM_EMP_ENTRY" required style="text-transform:uppercase;">
                            @error('ROUTE_ID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Route Path <span class="text-danger">*</span></label>
                            <input type="text" name="ROUTE_PATH"
                                class="form-control @error('ROUTE_PATH') is-invalid @enderror"
                                value="{{ old('route_path') }}" maxlength="200" placeholder="hrm/empentry" required>
                            @error('ROUTE_PATH')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Menu Child <span class="text-danger">*</span></label>
                            <select name="MENU_CHILD_ID" class="form-select @error('MENU_CHILD_ID') is-invalid @enderror"
                                required>
                                <option value="">Select menu</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->child_id }}"
                                        {{ old('menu_child_id') == $menu->child_id ? 'selected' : '' }}>
                                        {{ $menu->child_id }} - {{ $menu->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('MENU_CHILD_ID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub Menu Name</label>
                            <input type="text" name="SUB_MENU_NAME" class="form-control"
                                value="{{ old('sub_menu_name') }}" maxlength="100" placeholder="Employee Entry">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="DESCRIPTION" class="form-control" rows="2" maxlength="512">{{ old('DESCRIPTION') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Is Active</label>
                            <select name="IS_ACTIVE" class="form-select">
                                <option value="Y" {{ old('is_active', 'Y') == 'Y' ? 'selected' : '' }}>Y - Active
                                </option>
                                <option value="N" {{ old('is_active') == 'N' ? 'selected' : '' }}>N - Inactive
                                </option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100"><i class="bi bi-save me-1"></i>Save Route</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-signpost me-2"></i>All Routes
                    <span
                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle ms-1">{{ $routes->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Route ID</th>
                                    <th>Path</th>
                                    <th>Menu</th>
                                    <th>Sub Menu Name</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($routes as $route)
                                    <tr>
                                        <td><code>{{ $route->route_id }}</code></td>
                                        <td>{{ $route->route_path }}</td>
                                        <td><code>{{ $route->menu_child_id }}</code></td>
                                        <td>{{ $route->component ?: '-' }}</td>
                                        <td>
                                            @if ($route->is_active === 'Y')
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('routes.destroy', $route->route_id) }}" method="POST"
                                                onsubmit="return confirm('Delete this route?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No routes found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
