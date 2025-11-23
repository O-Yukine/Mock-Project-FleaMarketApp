<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;



class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', '');

        if ($request->has('keyword')) {
            session(['keyword' => $request->keyword]);
        } else {
            $keyword = session('keyword', '');
        }

        $keyword = $request->input('keyword', session('keyword', ''));

        if ($tab === '') {
            $tab = empty($keyword) ? (auth()->check() ? 'mylist' : 'recommended') : 'recommended';
        }

        if ($tab === 'mylist') {
            if (auth()->check()) {
                $products = auth()->user()->likes()->with('purchases')->ProductSearch($keyword)->get();
            } else {
                $products = collect();
            }
        } else {
            if (auth()->check()) {
                $products = Product::with('purchases')->where('user_id', '<>', auth()->id())->ProductSearch($keyword)->get();
            } else {
                $products = Product::with('purchases')->ProductSearch($keyword)->get();
            }
        }

        return view('products', compact('products', 'tab', 'keyword'));
    }

    public function showDetail($item_id)
    {
        $product = Product::with(['categories', 'condition', 'comments', 'likedBy'])->findOrFail($item_id);

        return view('detail', compact('product'));
    }


    public function showSellForm()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell_item', compact('categories', 'conditions'));
    }

    public function sellItem(ExhibitionRequest $request)
    {
        $filename = $request->file('product_image')->getClientOriginalName();
        $request->file('product_image')->storeAs('public/product_images', $filename);

        $product = Product::create([
            'product_image' => $filename,
            'condition_id' => $request->condition_id,
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'brand' => $request->brand,
            'content' => $request->input('content'),
            'price' => $request->input('price'),
        ]);

        $product->categories()->sync($request->categories);

        return redirect('/');
    }
}
