<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries', 'category'])->get();
        // dd($product);
        return view('pages.dashboard-products', [
            'products' => $products
        ]);
    }

    public function details(Request $request, $id)
    {
        $products = Product::with(['galleries', 'user', 'category'])->findOrFail($id);
        $categories = Category::all();

        return view('pages.dashboard-products-details', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-details', $request->products_id);
    }

    public function deleteGallery(string $id)
    {
        $item = ProductGallery::findOrFail($id);

        $item->delete();

        return redirect()->route('dashboard-product-details', $item->products_id);
    }

    public function create()
    {
        $categories = Category::all();
        // $users = User::all();

        return view('pages.dashboard-products-create', [
            'categories' => $categories,
            // 'users' => $users
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $product = Product::create($data);
        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product', 'public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('dashboard-product');
    }

    public function update(ProductRequest $request, string $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('dashboard-product');
    }

    public function delete(string $id)
    {
        $item = Product::findOrFail($id);
        $item2 = ProductGallery::where('products_id', $id);

        $item->delete();
        $item2->delete();

        return redirect()->route('dashboard-product');
    }
}
