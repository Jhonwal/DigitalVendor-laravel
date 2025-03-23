<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'published')
            ->with('category')
            ->latest();
        
        // Apply category filter if provided
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Apply price filter if provided
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $products = $query->paginate(12);
        
        $categories = Category::withCount('products')->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|image|max:2048',
            'file' => 'required|file|max:10240',
        ]);
        
        // Handle file uploads
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $filePath = $request->file('file')->store('products', 'private');
        
        // Create product
        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'thumbnail' => $thumbnailPath,
            'file_path' => $filePath,
            'status' => 'pending', // Require admin approval
        ]);
        
        return redirect()->route('user.products')
            ->with('success', 'Product created successfully and is pending approval.');
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->firstOrFail();
        
        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->take(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'file' => 'nullable|file|max:10240',
        ]);
        
        // Handle file uploads if provided
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $product->thumbnail = $thumbnailPath;
        }
        
        if ($request->hasFile('file')) {
            // Delete old file
            if ($product->file_path) {
                Storage::disk('private')->delete($product->file_path);
            }
            
            $filePath = $request->file('file')->store('products', 'private');
            $product->file_path = $filePath;
        }
        
        // Update product
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->category_id = $validated['category_id'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->status = 'pending'; // Require re-approval after update
        $product->save();
        
        return redirect()->route('user.products')
            ->with('success', 'Product updated successfully and is pending approval.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        // Delete files
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        
        if ($product->file_path) {
            Storage::disk('private')->delete($product->file_path);
        }
        
        $product->delete();
        
        return redirect()->route('user.products')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Display products by category.
     */
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(12);
        
        return view('products.category', compact('products', 'category'));
    }

    /**
     * Search for products.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(12);
        
        return view('products.search', compact('products', 'query'));
    }

    /**
     * Display the current user's products.
     */
    public function userProducts()
    {
        $products = Product::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);
        
        return view('products.user-products', compact('products'));
    }

    /**
     * Display all products for admin.
     */
    public function adminIndex()
    {
        $products = Product::with(['category', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Display a specific product for admin.
     */
    public function adminShow(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Update product status (admin only).
     */
    public function updateStatus(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|in:published,pending,rejected',
        ]);
        
        $product->status = $validated['status'];
        $product->save();
        
        return back()->with('success', 'Product status updated successfully.');
    }
}