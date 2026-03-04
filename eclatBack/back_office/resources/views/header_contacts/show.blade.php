@extends('layouts.admin')

@section('title', 'Header Contact Configuration Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Header Contact Configuration #{{ $headerContact->id }}</h5>
                    <a href="{{ route('admin.header-contacts.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <span class="badge {{ $headerContact->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                        {{ $headerContact->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <h6 class="mb-3">Contact Information</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Phone</th>
                            <td>{{ $headerContact->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $headerContact->email ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $headerContact->address ?? 'Not provided' }}</td>
                        </tr>
                    </tbody>
                </table>

                <h6 class="mb-3">Social Media Links</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Facebook</th>
                            <td>
                                @if($headerContact->facebook)
                                    <a href="{{ $headerContact->facebook }}" target="_blank" rel="noopener noreferrer">
                                        {{ $headerContact->facebook }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Twitter/X</th>
                            <td>
                                @if($headerContact->twitter)
                                    <a href="{{ $headerContact->twitter }}" target="_blank" rel="noopener noreferrer">
                                        {{ $headerContact->twitter }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>LinkedIn</th>
                            <td>
                                @if($headerContact->linkedin)
                                    <a href="{{ $headerContact->linkedin }}" target="_blank" rel="noopener noreferrer">
                                        {{ $headerContact->linkedin }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Instagram</th>
                            <td>
                                @if($headerContact->instagram)
                                    <a href="{{ $headerContact->instagram }}" target="_blank" rel="noopener noreferrer">
                                        {{ $headerContact->instagram }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>YouTube</th>
                            <td>
                                @if($headerContact->youtube)
                                    <a href="{{ $headerContact->youtube }}" target="_blank" rel="noopener noreferrer">
                                        {{ $headerContact->youtube }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <small class="text-muted">
                        Created: {{ $headerContact->created_at->format('M d, Y H:i:s') }} | 
                        Updated: {{ $headerContact->updated_at->format('M d, Y H:i:s') }}
                    </small>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.header-contacts.edit', $headerContact) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.header-contacts.destroy', $headerContact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this configuration?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
