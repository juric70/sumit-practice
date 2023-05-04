<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use http\Env\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return City::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $city_check = City::where('name', 'like', $request->input('name'))->exists();
        if (!$city_check){
                $city= new City([
                    'name'=> $request->input('name'),
                    'zip_code' => $request->input('zip_code'),
                    'state_id' => $request->input('state_id')
                ]);
                $city->save();
                return response()->json(['error'=> false, 'message'=>'The city is successfully added', 'status'=>201]);
        }else{
            return response()->json(['error'=> true,'message' => 'A city with this name already exists, so it cannot be added!', 'status'=>406]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function edit(int $id)
    {
        $city = City::find($id);
          if ($city == null){
              return response()->json(['error'=> true, 'message'=> 'City not found', 'status'=>404]);
          }
          else{
              return response()->json(['error'=>false, 'data'=>$city, 'status'=>200]);
          }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $city_check = City::where('name', 'like', $request->input('name'))->where('id', '<>', $id)->count();
        if($city_check > 0 ){
                return response()->json(['error'=> true,'message' => 'A city with this name already exists, therefore it cannot be updated to this name!', 'status'=>406]);
        }else{
            try {
                $city=City::find($id);
                $city->update($request->all());
                return response()->json('This city is successfully edited!');
            }
            catch (Exception $e){
                Log::error("Exception: " . $e->getMessage());
                return response()->json('Something went wrong!');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $city = City::find($id);
            if($city == null){
                return response()->json(['error'=>true, 'message'=>'City you want to delete does not exist, therefore you can not delete it!', 'status'=>404]);
            }else {
                $city->delete();
                return response()->json(['error'=>false, 'message'=>'City is successfully deleted!', 'status'=>200]);
            }
        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true,'message' => 'Something went wrong!', 'status'=>500]);
        }
    }
}
