<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Filter by Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by Year
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by Sorting
        if ($request->has('sort') && $request->sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:255',
            'cropped_image' => 'required|string',
            
            // Multiple images validation
            'supporting_images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'supporting_images.*.caption' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:500',
        ]);

        $imagePath = null;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'posts/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        } elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Determine excerpt (first 150 chars of content, stripping tags if necessary)
        $excerpt = Str::limit(strip_tags($request->content), 150);

        // Generate base slug
        $slug = Str::slug($request->title);
        // Ensure unique slug
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $excerpt,
            'category' => $request->category,
            'image' => $imagePath,
            'tags' => $request->tags,
            'is_published' => $request->has('is_published'),
            'user_id' => Auth::id() ?? 1, // fallback
        ]);

        // Process supporting images
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('posts/supporting', 'public');
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Berita/Artikel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::withTrashed()->with('images', 'user')->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $post->load('images');
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:255',
            'cropped_image' => 'nullable|string',
            
            // Multiple images validation
            'supporting_images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'supporting_images.*.caption' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:500',
            
            // Array of IDs of existing images that the user wants to DELETE
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:post_images,id'
        ]);

        $imagePath = $post->image;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'posts/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        } elseif ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Determine excerpt
        $excerpt = Str::limit(strip_tags($request->content), 150);

        // Update slug only if title changed
        $slug = $post->slug;
        if ($post->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $excerpt,
            'category' => $request->category,
            'image' => $imagePath,
            'tags' => $request->tags,
            'is_published' => $request->has('is_published'),
        ]);

        // Process existing supporting images deletion
        if ($request->has('delete_images')) {
            $imagesToDelete = PostImage::whereIn('id', $request->delete_images)->where('post_id', $post->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Process new supporting images
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('posts/supporting', 'public');
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Berita/Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita/Artikel berhasil diarsipkan.');
    }

    public function archives(Request $request)
    {
        $query = Post::onlyTrashed()->with('user');

        // Filter by Search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by Year
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by Sorting
        if ($request->has('sort') && $request->sort == 'oldest') {
            $query->oldest('deleted_at');
        } else {
            $query->latest('deleted_at');
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.archives', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts.archives')->with('success', 'Berita/Artikel berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        // Delete main image
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete supporting images
        $post->load('images');
        foreach ($post->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        
        $post->forceDelete();

        return redirect()->route('admin.posts.archives')->with('success', 'Berita/Artikel berhasil dihapus permanen.');
    }
}
