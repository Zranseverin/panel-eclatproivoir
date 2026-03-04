@extends('layouts.admin')

@section('title', 'Navbar Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Navbar Menu Management</h5>
                    <a href="{{ route('admin.navbars.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add New Menu Item
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Order</th>
                                <th width="40%">Title</th>
                                <th width="25%">URL</th>
                                <th width="10%">Type</th>
                                <th width="10%">Status</th>
                                <th width="10%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($navbars as $navbar)
                                @if(is_null($navbar->parent_id))
                                    <tr class="{{ $navbar->is_active ? '' : 'table-secondary' }}">
                                        <td>
                                            <span class="badge bg-primary">{{ $navbar->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $navbar->title }}</strong>
                                        </td>
                                        <td>
                                            <code>{{ $navbar->url }}</code>
                                        </td>
                                        <td>
                                            @if($navbar->children->count() > 0)
                                                <span class="badge bg-info">
                                                    <i class="bi bi-diagram-3 me-1"></i>Dropdown ({{ $navbar->children->count() }})
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Menu Item</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($navbar->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.navbars.show', $navbar) }}" 
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.navbars.edit', $navbar) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.navbars.destroy', $navbar) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure? This will also delete {{ $navbar->children->count() }} submenu items.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Display children -->
                                    @if($navbar->children->count() > 0)
                                        @foreach($navbar->children as $child)
                                            <tr class="{{ $child->is_active ? '' : 'table-secondary' }}" style="background-color: #f8f9fa;">
                                                <td>
                                                    <span class="badge bg-muted">{{ $navbar->order }}.{{ $loop->iteration }}</span>
                                                </td>
                                                <td>
                                                    <i class="bi bi-arrow-return-right text-muted me-2"></i>
                                                    {{ $child->title }}
                                                </td>
                                                <td>
                                                    <code>{{ $child->url }}</code>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">Submenu</span>
                                                </td>
                                                <td>
                                                    @if($child->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('admin.navbars.show', $child) }}" 
                                                           class="btn btn-sm btn-info">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.navbars.edit', $child) }}" 
                                                           class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('admin.navbars.destroy', $child) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('Delete this submenu item?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted"></i>
                                        <p class="text-muted mt-2">No menu items found. Create your first menu item!</p>
                                    </td>
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
