<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return State::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $state_check = State::where('name', 'like', $request->input('name'))->exists();
        if(!$state_check){
            $state = new State(['name'=>$request->input('name')]);
            $state->save();
            return response()->json(['error'=>false, 'message' => 'State successfully added!', 'status' => 201]);
        }else{
            return response()->json(['error'=> true,'message' => 'A state with this name already exists, so it cannot be added!', 'status'=>406]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $state = State::find($id);
        if($state == null){
            return response()->json(['error'=>true, 'message'=>'State not found', 'status'=>404]);
        }else{
            return response()->json(['error'=>false, 'data'=>$state, 'status'=>200]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $state_check = State::where('name', 'like', $request->input('name'))->where('id', '<>', $id)->count();
        if($state_check > 0){
            return response()->json(['error'=> true, 'message'=>'Name you want to update in state already exists!', 'status'=>406]);
        }else{
            try {
                $state = State::find($id);
                $state->update($request->all());
                return response()->json(['error'=>false, 'message'=>'State is successfully updated!', 'status'=>200]);
           }catch (\Exception $e){
                Log::error("Exception: " . $e->getMessage());
                return response()->json(['error'=> true,'message' => 'Something went wrong!', 'status'=>500]);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $state = State::find($id);
            if($state != null){
                $state->delete();
                return response()->json(['error'=>false, 'message'=>'State successfully deleted!', 'status'=>200]);
            }else{
                return response()->json(['error'=> true, 'message'=> 'State does not exist!', 'status'=>404]);
            }

        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true, 'message'=> 'Something went wrong!', 'status'=>500]);

        }
    }
}
