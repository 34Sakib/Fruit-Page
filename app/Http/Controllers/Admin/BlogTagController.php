<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')
            ->latest()
            ->paginate(20);

        return view('admin.blog.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.blog.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags,name',
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug',
        ]);

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        BlogTag::create($data);

        return redirect()
            ->route('admin.blog.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    public function show(BlogTag $tag)
    {
        $tag->load(['posts' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.blog.tags.show', compact('tag'));
    }

    public function edit(BlogTag $tag)
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    public function update(Request $request, BlogTag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags,name,' . $tag->id,
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug,' . $tag->id,
        ]);

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tag->update($data);

        return redirect()
            ->route('admin.blog.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    public function destroy(BlogTag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return redirect()
            ->route('admin.blog.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }
}
