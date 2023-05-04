<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Exception;
use http\Env\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = Event::all();
        if($event != null){
            return response()->json(['error' => false, 'data'=>$event, 'status'=>200]);
        }else{
            return response()->json(['error'=>false, 'data'=>null, 'status'=>204]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $event_check = Event::where('name', 'like', $request->input('name'))->exists();
        if (!$event_check) {
            $validatedDate = $request->validate([
                'name'=>'required|string',
                'description'=>'required|string',
                'available_seats'=>'required|integer',
                'contact_mail'=>'required|string',
                'starting_date'=>'required|string',
                'ending_date'=>'required|string',
                'city_id' => 'required|exists:cities,id',
            ]);
            $event = new Event([
                'name' => $validatedDate['name'],
                'description' => $validatedDate['description'],
                'available_seats' => $validatedDate['available_seats'],
                'contact_mail' => $validatedDate['contact_mail'],
                'starting_date' => $validatedDate['starting_date'],
                'ending_date' => $validatedDate['ending_date'],
                'city_id' => $validatedDate['city_id']
            ]);
            $event->save();
            return response()->json(['error' => false, 'message' => 'Event successfully created', 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'Name already exists!', 'status' => 406]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $event = Event::find($id);
        if($event!=null){
            return response()->json(['error'=>false, 'data'=>$event, 'status'=>200]);
        }else{
            return response()->json(['error'=>true, 'message'=>'Event does not exist!', 'status'=>404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $event_check = Event::where('name', 'like', $request->input('name'))->where('id', '<>', $id)->count();
        if ($event_check>0){
            return response()->json(['error'=>true, 'message'=>'Name already exists!', 'status'=>406]);
        }else{
            try {
                $event = Event::find($id);
                $validatedDate = $request->validate([
                    'name'=>'required|string',
                    'description'=>'required|string',
                    'available_seats'=>'required|integer',
                    'contact_mail'=>'required|string',
                    'starting_date'=>'required|string',
                    'ending_date'=>'required|string',
                    'city_id' => 'required|exists:cities,id',
                ]);
                $updatedData = [
                    'name' => $validatedDate['name'],
                    'description' => $validatedDate['description'],
                    'available_seats' => $validatedDate['available_seats'],
                    'contact_mail' => $validatedDate['contact_mail'],
                    'starting_date' => $validatedDate['starting_date'],
                    'ending_date' => $validatedDate['ending_date'],
                    'city_id' => $validatedDate['city_id']
                ];
                $event->update($updatedData);
                return response()->json(['error' => false, 'message' => 'Event successfully updated!', 'data' => $event, 'status' => 200]);

            }catch (Exception $e){
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
            $event = Event::find($id);
            if($event != null){
                $event->delete();
                    return response()->json(['error'=>false, 'message'=>'Event successfully deleted!', 'status'=>200]);
            }else{
                return response()->json(['error'=> true, 'message'=> 'Event does not exist!', 'status'=>404]);
            }
        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true, 'message'=> 'Something went wrong!', 'status'=>500]);
        }
    }
}
