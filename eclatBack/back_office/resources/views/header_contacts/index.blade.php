@extends('layouts.admin')

@section('title', 'Header Contact Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Header Contact Management</h5>
                    <a href="{{ route('admin.header-contacts.create') }}" class="btn btn-primary btn-sm">Add New Configuration</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Social Media</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->phone ?? 'N/A' }}</td>
                                    <td>{{ $contact->email ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($contact->address ?? 'N/A', 30) }}</td>
                                    <td>
                                        @if($contact->facebook || $contact->twitter || $contact->linkedin || $contact->instagram || $contact->youtube)
                                            <span class="badge bg-info">Configured</span>
                                        @else
                                            <span class="badge bg-secondary">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contact->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.header-contacts.show', $contact) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('admin.header-contacts.edit', $contact) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.header-contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this configuration?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No header contact configurations found</td>
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
