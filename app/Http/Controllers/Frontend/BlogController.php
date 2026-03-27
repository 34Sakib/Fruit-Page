<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->with(['author', 'category', 'tags'])
            ->latest()
            ->paginate(9);

        $featuredPosts = BlogPost::published()
            ->with(['author', 'category', 'tags'])
            ->latest()
            ->take(3)
            ->get();

        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])->get();

        $popularTags = BlogTag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        return view('frontend.blog.index', compact('posts', 'featuredPosts', 'categories', 'popularTags'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['tags', 'author', 'category'])
            ->firstOrFail();

        $relatedPosts = BlogPost::where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->published()
            ->with(['author', 'category'])
            ->latest()
            ->take(3)
            ->get();

        $latestPosts = BlogPost::where('id', '!=', $post->id)
            ->published()
            ->with(['author', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $popularTags = BlogTag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'latestPosts', 'popularTags'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->firstOrFail();

        $posts = BlogPost::where('category_id', $category->id)
            ->published()
            ->latest()
            ->paginate(9);

        return view('frontend.blog.category', compact('category', 'posts'));
    }
}
