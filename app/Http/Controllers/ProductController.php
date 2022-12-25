<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
class ProductController extends Controller
{
     public function index()
    {
        $products=Product::get();
         return view('/products.index', compact('products'));
    }

     public function show($id)
    {
        $product=Product::findorfail($id);
        $intent = (new User())->createSetupIntent();
         return view('/products.show', compact('product','intent'));
    }

     public function payment(Request $request)
    {
      $product = Product::find($request->product_id);
      $user          = (new User());
      $paymentMethod = $request->input('payment_method');
     try {
         $user->name=$request->card_holder_name;
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->charge($product->price * 100, $paymentMethod, [
    'description' => $product->name, 'customer' => $request->card_holder_name]);        
    } catch (\Exception $exception) {
        return back()->with('error', $exception->getMessage());
    }
      return redirect()->route('products.success')->with('message', 'Product purchased successfully!');

    }
}
