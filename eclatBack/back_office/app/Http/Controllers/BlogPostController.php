<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index()
    {
        $blogPosts = BlogPost::all();
        return view('blog_posts.index', compact('blogPosts'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        return view('blog_posts.create');
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:100',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image uploads
        $imageUrl = $request->image_url; // Default to existing URL if provided
        $authorImageUrl = $request->author_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }
        
        if ($request->hasFile('author_image')) {
            $authorImagePath = $request->file('author_image')->store('author_images', 'public');
            $authorImageUrl = asset('storage/' . $authorImagePath);
        }

        $blogPost = BlogPost::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'image_url' => $imageUrl,
            'author' => $request->author,
            'author_image_url' => $authorImageUrl,
            'views' => $request->views ?? 0,
            'comments' => $request->comments ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.blog_posts.index')
                         ->with('success', 'Article de blog créé avec succès.');
    }

    /**
     * Display the specified blog post.
     */
    public function show(BlogPost $blogPost)
    {
        return view('blog_posts.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(BlogPost $blogPost)
    {
        return view('blog_posts.edit', compact('blogPost'));
    }

    /**
     * Update the specified blog post in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:100',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image uploads
        $imageUrl = $request->image_url; // Default to existing URL if provided
        $authorImageUrl = $request->author_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($blogPost->image_url) {
                $oldImagePath = str_replace(asset(''), '', $blogPost->image_url);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }
            
            $imagePath = $request->file('image')->store('blog_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }
        
        if ($request->hasFile('author_image')) {
            // Delete old author image if it exists
            if ($blogPost->author_image_url) {
                $oldAuthorImagePath = str_replace(asset(''), '', $blogPost->author_image_url);
                if (file_exists(public_path($oldAuthorImagePath))) {
                    unlink(public_path($oldAuthorImagePath));
                }
            }
            
            $authorImagePath = $request->file('author_image')->store('author_images', 'public');
            $authorImageUrl = asset('storage/' . $authorImagePath);
        }

        $blogPost->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'image_url' => $imageUrl ?? $blogPost->image_url,
            'author' => $request->author ?? $blogPost->author,
            'author_image_url' => $authorImageUrl ?? $blogPost->author_image_url,
            'views' => $request->views ?? $blogPost->views,
            'comments' => $request->comments ?? $blogPost->comments,
            'is_active' => $request->is_active ?? $blogPost->is_active,
        ]);

        return redirect()->route('admin.blog_posts.index')
                         ->with('success', 'Article de blog mis à jour avec succès.');
    }

    /**
     * Remove the specified blog post from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        // Delete the image files if they exist
        if ($blogPost->image_url) {
            $imagePath = str_replace(asset(''), '', $blogPost->image_url);
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        }
        
        if ($blogPost->author_image_url) {
            $authorImagePath = str_replace(asset(''), '', $blogPost->author_image_url);
            if (file_exists(public_path($authorImagePath))) {
                unlink(public_path($authorImagePath));
            }
        }
        
        $blogPost->delete();

        return redirect()->route('admin.blog_posts.index')
                         ->with('success', 'Article de blog supprimé avec succès.');
    }
}