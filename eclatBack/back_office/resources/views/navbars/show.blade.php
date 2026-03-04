@extends('layouts.admin')

@section('title', 'Menu Item Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-menu-button-wide me-2"></i>Menu Item Details</h5>
                    <a href="{{ route('admin.navbars.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    @if($navbar->is_active)
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-check-circle me-1"></i>Active
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="bi bi-x-circle me-1"></i>Inactive
                        </span>
                    @endif
                </div>

                <!-- Basic Information -->
                <h6 class="border-bottom pb-2 mb-3">Basic Information</h6>
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Menu ID</th>
                            <td>#{{ $navbar->id }}</td>
                        </tr>
                        <tr>
                            <th>Menu Title</th>
                            <td><strong>{{ $navbar->title }}</strong></td>
                        </tr>
                        <tr>
                            <th>URL</th>
                            <td><code>{{ $navbar->url }}</code></td>
                        </tr>
                        @if($navbar->route_name)
                        <tr>
                            <th>Laravel Route Name</th>
                            <td><code>{{ $navbar->route_name }}</code></td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Configuration Details -->
                <h6 class="border-bottom pb-2 mb-3">Configuration</h6>
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Display Order</th>
                            <td>
                                <span class="badge bg-primary">{{ $navbar->order }}</span>
                                @if($navbar->order == 0)
                                    <small class="text-muted ms-2">(Default order)</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Menu Type</th>
                            <td>
                                @if(is_null($navbar->parent_id))
                                    @if($navbar->children->count() > 0)
                                        <span class="badge bg-info">
                                            <i class="bi bi-diagram-3 me-1"></i>Dropdown Parent ({{ $navbar->children->count() }} items)
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-list-ul me-1"></i>Top Level Menu
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-arrow-return-right me-1"></i>Submenu Item
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @if($navbar->parent)
                        <tr>
                            <th>Parent Menu</th>
                            <td>
                                <a href="{{ route('admin.navbars.show', $navbar->parent) }}">
                                    {{ $navbar->parent->title }}
                                </a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Children Items -->
                @if($navbar->children->count() > 0)
                    <h6 class="border-bottom pb-2 mb-3">
                        Submenu Items ({{ $navbar->children->count() }})
                    </h6>
                    <div class="list-group mb-4">
                        @foreach($navbar->children as $child)
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-arrow-return-right text-muted me-2"></i>
                                    <strong>{{ $child->title }}</strong>
                                    <small class="text-muted ms-2">→ {{ $child->url }}</small>
                                    @if(!$child->is_active)
                                        <span class="badge bg-secondary ms-2">Inactive</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('admin.navbars.edit', $child) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.navbars.show', $child) }}" 
                                       class="btn btn-sm btn-info ms-1" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Timestamps -->
                <div class="mt-4 p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="bi bi-clock-history me-2"></i>
                        Created: <strong>{{ $navbar->created_at->format('M d, Y H:i:s') }}</strong> | 
                        Updated: <strong>{{ $navbar->updated_at->format('M d, Y H:i:s') }}</strong>
                    </small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.navbars.edit', $navbar) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit this Item
                    </a>
                    <form action="{{ route('admin.navbars.destroy', $navbar) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure? This will also delete {{ $navbar->children->count() }} submenu items.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
