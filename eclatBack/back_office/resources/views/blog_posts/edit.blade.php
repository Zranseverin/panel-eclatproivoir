@extends('layouts.admin')

@section('title', 'Modifier un Article de Blog')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un Article de Blog</h5>
                    <a href="{{ route('admin.blog_posts.index') }}" class="btn btn-secondary btn-sm">Retour aux Articles</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog_posts.update', $blogPost) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blogPost->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Sous-titre</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $blogPost->subtitle) }}">
                        @error('subtitle')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea class="form-control" id="content" name="content" rows="6">{{ old('content', $blogPost->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Image de l'Article</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($blogPost->image_url)
                                    <div class="mt-2">
                                        <img src="{{ $blogPost->image_url }}" alt="{{ $blogPost->title }}" style="max-height: 100px;">
                                    </div>
                                @endif
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Téléchargez une nouvelle image pour illustrer l'article</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image_url" class="form-label">URL de l'Image</label>
                                <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $blogPost->image_url) }}">
                                @error('image_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ou entrez une URL d'image (optionnel si vous téléchargez une image)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">Auteur</label>
                                <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $blogPost->author) }}">
                                @error('author')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="author_image" class="form-label">Image de l'Auteur</label>
                                <input type="file" class="form-control" id="author_image" name="author_image" accept="image/*">
                                @if($blogPost->author_image_url)
                                    <div class="mt-2">
                                        <img src="{{ $blogPost->author_image_url }}" alt="{{ $blogPost->author }}" style="max-height: 100px;">
                                    </div>
                                @endif
                                @error('author_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Téléchargez une nouvelle image pour l'auteur</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="author_image_url" class="form-label">URL de l'Image de l'Auteur</label>
                                <input type="text" class="form-control" id="author_image_url" name="author_image_url" value="{{ old('author_image_url', $blogPost->author_image_url) }}">
                                @error('author_image_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ou entrez une URL d'image (optionnel si vous téléchargez une image)</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="views" class="form-label">Nombre de Vues</label>
                                <input type="number" class="form-control" id="views" name="views" value="{{ old('views', $blogPost->views) }}" min="0">
                                @error('views')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Nombre de Commentaires</label>
                                <input type="number" class="form-control" id="comments" name="comments" value="{{ old('comments', $blogPost->comments) }}" min="0">
                                @error('comments')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $blogPost->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Article Actif</label>
                        @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Mettre à jour l'Article</button>
                        <a href="{{ route('admin.blog_posts.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection