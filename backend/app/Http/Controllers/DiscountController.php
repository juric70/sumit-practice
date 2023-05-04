<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Exception\TimeSourceException;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount = Discount::all();
        if($discount != null){
            return response()->json(['error' => false, 'data'=>$discount, 'status'=>200]);
        }else{
            return response()->json(['error'=>false, 'data'=>null, 'status'=>204]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $discount_check = Discount::where('code', 'like', $request->input('code'))->exists();
        if (!$discount_check) {
            $validatedDate = $request->validate([
                'description'=>'required|string',
                'code'=>'required|string',
                'amount_of_cards'=>'required|float',
                'amount_of_presentation'=>'required|float',
                'event_id' => 'required|exists:events,id',
            ]);
            $discount = new Discount([
                'description' => $validatedDate['description'],
                'code' => $validatedDate['code'],
                'amount_of_cards' => $validatedDate['amount_of_cards'],
                'amount_of_presentation' => $validatedDate['amount_of_presentation'],
                'event_id' => $validatedDate['event_id']
            ]);
            $discount->save();
            return response()->json(['error' => false, 'message' => 'Discount successfully created', 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'Name already exists!', 'status' => 406]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\Http\JsonResponse
    {
        $discount = Discount::find($id);
        if($discount!=null){
            return response()->json(['error'=>false, 'data'=>$discount, 'status'=>200]);
        }else{
            return response()->json(['error'=>true, 'message'=>'Discount does not exist!', 'status'=>404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $discount_check = Company::where('code', 'like', $request->input('code'))->where('id', '<>', $id).count();
        if ($discount_check>0) {
                return response()->json(['error' => true, 'message' => 'Name already exists!', 'status' => 406]);

        } else {
            try {
                $validatedDate = $request->validate([
                    'description'=>'required|string',
                    'code'=>'required|string|unique',
                    'amount_of_cards'=>'float',
                    'amount_of_presentation'=>'float',
                    'event_id' => 'required|exists:events,id',
                ]);
                $discount = Discount::find($id);
                $updatedData = [
                    'description' => $validatedDate['description'],
                    'code' => $validatedDate['code'],
                    'amount_of_cards' => $validatedDate['amount_of_cards'],
                    'amount_of_presentation' => $validatedDate['amount_of_presentation'],
                    'event_id' => $validatedDate['event_id']
                ];
                $discount->update($updatedData);
                return response()->json(['error' => false, 'message' => 'Discount successfully created', 'status' => 200]);

            }catch (\Exception $e){
                Log::error("Exception: " . $e->getMessage());
                return response()->json(['error'=> true,'message' => 'Something went wrong!', 'status'=>500]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        try{
            $discount = Discount::find($id);
            if($discount != null){
                $discount->delete();
                return response()->json(['error'=>false, 'message'=>'Discount successfully deleted!', 'status'=>200]);
            }else{
                return response()->json(['error'=> true, 'message'=> 'Discount does not exist!', 'status'=>404]);
            }
        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true, 'message'=> 'Something went wrong!', 'status'=>500]);
        }
    }
}
