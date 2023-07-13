<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\User;
use App\Http\Resources\Inventories\InventoryResource;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index()
    {
        // $user = auth()->user();

        // if(in_array("Administrator", $user->roles->pluck("name")->toArray())){
        return InventoryResource::collection(Inventory::orderBy('created_at', 'desc')->get());
        // };
    }

    public function store(Request $request)
    {
        $inventory = Inventory::where(['name'=> $request->name])->first();
        $user_id = User::where("uuid", $request->uuid)->first()->id;

        if($inventory) return response()->json([
            'status' => 'error',
            'message' => 'Inventory already exists.',
        ]);

        Inventory::create([
            'name' => $request->name,
            'user_id' => $user_id,
            'uuid' => Str::uuid()->toString()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory created successfully.',
        ]);
    }

    public function update(Request $request)
    {
        $inventory = Inventory::where("uuid", $request->uuid)->first();

        if(!$inventory) return response()->json([
            'status' => 'error',
            'message' => 'Inventory does not exists.',
        ]);

        $inventory->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $inventory = Inventory::where("uuid", $request->uuid)->first();
        $inventory->delete();

        return response()->json([
            'message' => 'Inventory deleted successfully.',
            'status' => 'success'
        ]);
    }
}
