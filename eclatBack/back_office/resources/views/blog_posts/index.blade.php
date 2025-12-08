@extends('layouts.admin')

@section('title', 'Gestion des Articles de Blog')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Articles de Blog</h5>
                    <a href="{{ route('admin.blog_posts.create') }}" class="btn btn-primary btn-sm">Ajouter un Article</a>
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
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Image</th>
                                <th>Vues</th>
                                <th>Commentaires</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogPosts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>
                                        <div>{{ $post->title }}</div>
                                        @if($post->subtitle)
                                            <small class="text-muted">{{ Str::limit($post->subtitle, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $post->author ?? 'Non spécifié' }}</td>
                                    <td>
                                        @if($post->image_url)
                                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="max-height: 50px; max-width: 100px;">
                                        @else
                                            <span>Aucune image</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->views }}</td>
                                    <td>{{ $post->comments }}</td>
                                    <td>
                                        @if($post->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.blog_posts.show', $post) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.blog_posts.edit', $post) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.blog_posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article de blog?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun article de blog trouvé</td>
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