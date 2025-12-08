@extends('layouts.admin')

@section('title', 'Hero Content Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Hero Content Management</h5>
                    <a href="{{ route('admin.hero_contents.create') }}" class="btn btn-primary btn-sm">Add New Hero Content</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Headline</th>
                                <th>Subheading</th>
                                <th>Primary Button</th>
                                <th>Secondary Button</th>
                                <th>Background Color</th>
                                <th>Text Color</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($heroContents as $content)
                                <tr>
                                    <td>{{ $content->id }}</td>
                                    <td>{{ $content->headline }}</td>
                                    <td>{{ $content->subheading ?? 'N/A' }}</td>
                                    <td>{{ $content->primary_button_text ?? 'N/A' }}</td>
                                    <td>{{ $content->secondary_button_text ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $content->background_color ?? '#009900' }}">
                                            {{ $content->background_color ?? '#009900' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $content->text_color ?? '#ffffff' }}; color: #000">
                                            {{ $content->text_color ?? '#ffffff' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($content->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.hero_contents.show', $content) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('admin.hero_contents.edit', $content) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.hero_contents.destroy', $content) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hero content?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hero contents found</td>
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