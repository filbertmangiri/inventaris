<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Traits\HasImage;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HasImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user')->paginate(10);

        $categories = Category::get();

        $suppliers = Supplier::get();

        return view('admin.order.index', compact('orders', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::get();

        $categories = Category::get();

        $suppliers = Supplier::get();

        return view('admin.order.create', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $product = Product::find($request->product_id);
        $product->update([
            'quantity' => $product->quantity + $request->quantity,
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'name' => $product->name,
            'quantity' => $request->quantity,
            'status' => OrderStatus::Done,
            'image' => basename($product->image),
            'unit' => $product->unit,
        ]);

        return redirect((route('admin.order.index')))->with('toast_success', 'Permintaan Barang Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $image = $this->uploadImage($request, $path = 'public/products/', $name = 'image');

        if($order->status == OrderStatus::Pending){
            $order->update([
                'status' => OrderStatus::Verified,
            ]);
        }else{
            Product::create([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'image' => $image->hashName(),
                'unit' => $request->unit,
                'description' => $request->description,
                'quantity' => $request->quantity
            ]);

            $order->update([
                'status' => OrderStatus::Success
            ]);
        }

        return back()->with('toast_success', 'Permintaan Barang Berhasil Dikonfirmasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $product = Product::where('name', $order->name)->first();

        $product->update([
            'quantity' => max($product->quantity - $order->quantity, 0),
        ]);

        $order->delete();

        return redirect((route('admin.order.index')))->with('toast_success', 'Permintaan Barang Berhasil Dihapus');
    }
}
