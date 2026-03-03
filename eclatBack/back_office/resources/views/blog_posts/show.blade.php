@extends('layouts.admin')

@section('title', 'Détails de l'Article de Blog')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails de l'Article de Blog</h5>
                    <a href="{{ route('admin.blog_posts.index') }}" class="btn btn-secondary btn-sm">Retour aux Articles</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <p class="form-control-plaintext">{{ $blogPost->title }}</p>
                        </div>
                        
                        @if($blogPost->subtitle)
                            <div class="mb-3">
                                <label class="form-label">Sous-titre</label>
                                <p class="form-control-plaintext">{{ $blogPost->subtitle }}</p>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label">Contenu</label>
                            <div class="form-control-plaintext">
                                {!! nl2br(e($blogPost->content)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        @if($blogPost->image_url)
                            <div class="mb-3">
                                <label class="form-label">Image de l'Article</label>
                                <div class="mt-2">
                                    <img src="{{ $blogPost->image_url }}" alt="{{ $blogPost->title }}" class="img-fluid">
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label">Auteur</label>
                            <p class="form-control-plaintext">
                                @if($blogPost->author_image_url)
                                    <img src="{{ $blogPost->author_image_url }}" alt="{{ $blogPost->author }}" style="max-height: 30px; border-radius: 50%;">
                                @endif
                                {{ $blogPost->author ?? 'Non spécifié' }}
                            </p>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Vues</label>
                                    <p class="form-control-plaintext">{{ $blogPost->views }}</p>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Commentaires</label>
                                    <p class="form-control-plaintext">{{ $blogPost->comments }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <p class="form-control-plaintext">
                                @if($blogPost->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-secondary">Inactif</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de Création</label>
                            <p class="form-control-plaintext">{{ $blogPost->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Dernière Modification</label>
                            <p class="form-control-plaintext">{{ $blogPost->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.blog_posts.edit', $blogPost) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.blog_posts.destroy', $blogPost) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article de blog?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection