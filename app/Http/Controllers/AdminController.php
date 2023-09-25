<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function adminLoginRequest(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $adminLogin = Admin::where('username', '=', $request->username)->first();

        if($adminLogin && Hash::check($request->password,$adminLogin->password)){
            $request->session()->put('Admin',$adminLogin->id);
            return redirect('adminSales');
            
        }else{
            return back()->with('fail', 'Invalid credentials');
        }
    }

    public function adminSales(){
        $sales = Sale::whereYear('created_at', '=', 12)
        ->whereMonth('created_at', '=', 01)
        ->get();
        return view('admin.adminSales')
        ->with(['sales' => $sales]);
    }

    public function updateTime(Request $request){
        $monthNum = substr($request->datepicker, 0, -5);
        $month = date("F", mktime(null, null, null, $monthNum));

        $yearNum = substr($request->datepicker, 3, 7);

        $sales = Sale::whereYear('created_at', '=', $yearNum)
              ->whereMonth('created_at', '=', $monthNum)
              ->get();

        return view('admin.adminSales')->with(['sales' => $sales]);
    }

    public function customers(){
        $customers =  Customer::all();
        return view('admin.adminCustomer')->with(['customers' => $customers]);
    }

    public function addProduct(Request $request){
        $request->validate([
            'product' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,jfif',
            'remaining' => 'required|integer',
            'tag' => 'required'
        ],
        [
            'image.required' => 'Please upload your product image',
            'remaining.required' => 'The quantity field is required',
            'tag.required' => 'Please select your tag for your product'
        ]);

        $fileName = $request->image->getClientOriginalName();
        $path = "products/";
        $fullFile = $path . $fileName;
       
        $request->file('image')->move(public_path('products'), $fileName);

        $product = Product::create([
            'product' => $request->product,
            'price' => $request->price,
            'description' => $request->description,
            'remaining' => $request->remaining,
            'max_quantity' => $request->remaining,
            'image' => $fullFile
        ]);


        $productID = Product::orderBy('id', 'DESC')->first();

        
        $tagging = Tag::create([
            'productID' => $productID['id'],
            'tagName' => $request->tag,
        ]);

        return back()->with('success', 'Your product has been added');
        
    }

    public function productList(){
        $products = Product::all();
        return view('admin.AdminProductList')->with(['products' => $products]);
    }

    public function logout(){
        if(session()->has('Admin')){
            session()->pull('Admin');
            return redirect('home');
        }
    }

}