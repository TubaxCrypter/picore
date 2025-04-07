<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::query();
        
        // Filtreleme
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }
        
        // Sayfalama ve ilişkili verileri alma
        $blogs = $query->with(['category', 'author'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10)
                      ->withQueryString();
        
        // Kategorileri alma
        $categories = Category::all();
        
        return Inertia::render('Blogs/Index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'filters' => $request->only(['search', 'status', 'category']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|string|in:draft,review,planning,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
        ]);
        
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->user_id = Auth::id();
        
        if ($request->status === 'published' && $request->has('published_at')) {
            $blog->published_at = $request->published_at;
        } elseif ($request->status === 'published') {
            $blog->published_at = now();
        }
        
        $blog->save();
        
        return redirect()->route('blogs.index')
                         ->with('success', 'Blog başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response()->json($blog->load(['category', 'author']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|string|in:draft,review,planning,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
        ]);
        
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        
        if ($request->status === 'published' && !$blog->published_at && $request->has('published_at')) {
            $blog->published_at = $request->published_at;
        } elseif ($request->status === 'published' && !$blog->published_at) {
            $blog->published_at = now();
        }
        
        $blog->save();
        
        return redirect()->route('blogs.index')
                         ->with('success', 'Blog başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        
        return redirect()->route('blogs.index')
                         ->with('success', 'Blog başarıyla silindi.');
    }
} 