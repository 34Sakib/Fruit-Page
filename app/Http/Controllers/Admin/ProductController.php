<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.products.edit', $row->id).'" class="btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="'.route('admin.products.destroy', $row->id).'" method="POST" style="display:inline">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->addColumn('category', function($row){
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        // For non-AJAX requests, return the view with paginated products
        $products = Product::with('category')->latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->pluck('name', 'id');
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image1', 'image2', 'image3']);
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_top_product'] = $request->has('is_top_product') ? 1 : 0;

        $imagePaths = [];
        
        if ($request->hasFile('image1')) {
            $imagePaths[] = $request->file('image1')->store('products', 'public');
        }
        
        if ($request->hasFile('image2')) {
            $imagePaths[] = $request->file('image2')->store('products', 'public');
        }
        
        if ($request->hasFile('image3')) {
            $imagePaths[] = $request->file('image3')->store('products', 'public');
        }
        
        if (!empty($imagePaths)) {
            $data['images'] = $imagePaths;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('backend.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->pluck('name', 'id');
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image1', 'image2', 'image3']);
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_top_product'] = $request->has('is_top_product') ? 1 : 0;

        $imagePaths = [];
        $hasNewImages = false;
        
        if ($request->hasFile('image1')) {
            $imagePaths[] = $request->file('image1')->store('products', 'public');
            $hasNewImages = true;
        } elseif ($product->images && isset($product->images[0])) {
            $imagePaths[] = $product->images[0];
        }
        
        if ($request->hasFile('image2')) {
            $imagePaths[] = $request->file('image2')->store('products', 'public');
            $hasNewImages = true;
        } elseif ($product->images && isset($product->images[1])) {
            $imagePaths[] = $product->images[1];
        }
        
        if ($request->hasFile('image3')) {
            $imagePaths[] = $request->file('image3')->store('products', 'public');
            $hasNewImages = true;
        } elseif ($product->images && isset($product->images[2])) {
            $imagePaths[] = $product->images[2];
        }
        
        if ($hasNewImages) {
            // Delete old images if exist
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $oldImage) {
                    Storage::delete('public/' . $oldImage);
                }
            }
        }
        
        if (!empty($imagePaths)) {
            $data['images'] = $imagePaths;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $image) {
                Storage::delete('public/' . $image);
            }
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
