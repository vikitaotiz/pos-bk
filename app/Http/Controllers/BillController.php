<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Http\Resources\Bills\BillResource;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        // $user = auth()->user();

        // if(in_array("Administrator", $user->bills->pluck("name")->toArray())){
            return BillResource::collection(Bill::orderBy('created_at', 'desc')->get());
        // };
    }

    public function store(Request $request)
    {
        $role = Bill::where('name', $request->name)->first();
        $user_id = User::where("uuid", $request->uuid)->first()->id;

        if($role) return response()->json([
            'status' => 'error',
            'message' => 'Bill already exists.',
        ]);

        Bill::create([
            'status' => $request->status,
            'selling_price' => $request->selling_price,
            'payment_mode_id' => $request->payment_mode_id,
            'user_id' => $user_id,
            'uuid' => Str::uuid()->toString()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bill created successfully.',
            'name' => $request->name
        ]);
    }

    public function update(Request $request)
    {
        $role = Bill::where("uuid", $request->uuid)->first();

        if(!$role) return response()->json([
            'status' => 'error',
            'message' => 'Bill does not exists.',
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bill updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $role = Bill::where("uuid", $request->uuid)->first();
        $role->delete();

        return response()->json([
            'message' => 'Bill deleted successfully.',
            'status' => 'success'
        ]);
    }
}
