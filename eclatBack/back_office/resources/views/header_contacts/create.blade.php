@extends('layouts.admin')

@section('title', 'Create Header Contact Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">Create New Header Contact Configuration</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.header-contacts.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               placeholder="+123 456 7890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="info@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Physical Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" 
                                  name="address" 
                                  rows="3"
                                  placeholder="123 Street, City, Country">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Social Media Links</h6>

                    <div class="mb-3">
                        <label for="facebook" class="form-label">
                            <i class="fab fa-facebook-f me-2"></i>Facebook URL
                        </label>
                        <input type="url" 
                               class="form-control @error('facebook') is-invalid @enderror" 
                               id="facebook" 
                               name="facebook" 
                               value="{{ old('facebook') }}"
                               placeholder="https://facebook.com/your-page">
                        @error('facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="twitter" class="form-label">
                            <i class="fab fa-twitter me-2"></i>Twitter/X URL
                        </label>
                        <input type="url" 
                               class="form-control @error('twitter') is-invalid @enderror" 
                               id="twitter" 
                               name="twitter" 
                               value="{{ old('twitter') }}"
                               placeholder="https://twitter.com/your-profile">
                        @error('twitter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="linkedin" class="form-label">
                            <i class="fab fa-linkedin-in me-2"></i>LinkedIn URL
                        </label>
                        <input type="url" 
                               class="form-control @error('linkedin') is-invalid @enderror" 
                               id="linkedin" 
                               name="linkedin" 
                               value="{{ old('linkedin') }}"
                               placeholder="https://linkedin.com/company/your-company">
                        @error('linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="instagram" class="form-label">
                            <i class="fab fa-instagram me-2"></i>Instagram URL
                        </label>
                        <input type="url" 
                               class="form-control @error('instagram') is-invalid @enderror" 
                               id="instagram" 
                               name="instagram" 
                               value="{{ old('instagram') }}"
                               placeholder="https://instagram.com/your-profile">
                        @error('instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube" class="form-label">
                            <i class="fab fa-youtube me-2"></i>YouTube URL
                        </label>
                        <input type="url" 
                               class="form-control @error('youtube') is-invalid @enderror" 
                               id="youtube" 
                               name="youtube" 
                               value="{{ old('youtube') }}"
                               placeholder="https://youtube.com/c/your-channel">
                        @error('youtube')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               class="form-check-input" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Set as Active Configuration (only one can be active at a time)
                        </label>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Configuration</button>
                        <a href="{{ route('admin.header-contacts.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
