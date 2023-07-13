<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use App\Models\Bill;
use App\Models\PaymentMode;
use App\Http\Resources\Sales\SaleResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        // $user = auth()->user();

        // if(in_array("Administrator", $user->roles->pluck("name")->toArray())){
        return SaleResource::collection(Sale::orderBy('created_at', 'desc')->get());
        // };
    }

    public function store(Request $request)
    {
        $sale = Sale::where(['name'=> $request->name])->first();
        $user_id = User::where("uuid", $request->uuid)->first()->id;
        $bill_id = 1;

        if($sale) return response()->json([
            'status' => 'error',
            'message' => 'Sale already exists.',
        ]);

        Sale::create([
            'name' => $request->name,
            'user_id' => $user_id,
            'payment_mode_id' => $request->payment_mode_id,
            'bill_id' => $bill_id,
            'status' => 'sold',
            'quantity' => $request->quantity,
            'uuid' => Str::uuid()->toString()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sale created successfully.',
        ]);
    }

    public function create_bill_sales(Request $request) {

        $user_id = User::where("uuid", $request->uuid)->first()->id;
        $payment_mode_id = PaymentMode::where("uuid", $request->payment_mode_uuid)->first()->id;

        $bill = Bill::create([
            'uuid' => Str::uuid()->toString(),
            'status' => 'sold',
            'user_id' => $user_id,
            'selling_price' => $request->selling_price,
            'payment_mode_id' => $payment_mode_id
        ]);

        foreach ($request->products as $product) {
            Sale::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'user_id' => $user_id,
                'bill_id' => $bill->id,
                'status' => "sold"
            ]);
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Sale created successfully.',
        ]);
    }

    public function create_bill_sales_pending(Request $request) {

        $user_id = User::where("uuid", $request->uuid)->first()->id;

        $bill = Bill::create([
            'uuid' => Str::uuid()->toString(),
            'status' => 'pending',
            'user_id' => $user_id,
            'selling_price' => 0,
            'payment_mode_id' => 3
        ]);

        foreach ($request->products as $product) {
            Sale::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'user_id' => $user_id,
                'bill_id' => $bill->id,
                'status' => "pending"
            ]);
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Sale sent to pending',
        ]);
    }

    public function update(Request $request)
    {
        $sale = Sale::where("uuid", $request->uuid)->first();

        if(!$sale) return response()->json([
            'status' => 'error',
            'message' => 'Sale does not exists.',
        ]);

        $sale->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sale updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $sale = Sale::where("uuid", $request->uuid)->first();
        $sale->delete();

        return response()->json([
            'message' => 'Sale deleted successfully.',
            'status' => 'success'
        ]);
    }

    public function salesLastSevenDays(){

        $today_sales = Bill::whereDate( 'created_at', Carbon::now()->toDateString())->get();

        $yesterday_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(1)->toDateString())
           ->get();

        $twoDaysAgo_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(2)->toDateString())
           ->get();

        $threeDaysAgo_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(3)->toDateString())
           ->get();

        $fourDaysAgo_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(4)->toDateString())
           ->get();

        $fiveDaysAgo_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(5)->toDateString())
           ->get();

        $sixDaysAgo_sales = Bill::whereDate( 'created_at', Carbon::now()->subDays(6)->toDateString())
           ->get();

        $sales = array(
            array("day" => Carbon::now()->format('l'), "sales" => $today_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(1)->format('l'), "sales" => $yesterday_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(2)->format('l'), "sales" => $twoDaysAgo_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(3)->format('l'), "sales" => $threeDaysAgo_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(4)->format('l'), "sales" => $fourDaysAgo_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(5)->format('l'), "sales" => $fiveDaysAgo_sales->sum('selling_price')),
            array("day" => Carbon::now()->subDays(6)->format('l'), "sales" => $sixDaysAgo_sales->sum('selling_price'))
        );

        return array("data" => $sales);
    }
}
