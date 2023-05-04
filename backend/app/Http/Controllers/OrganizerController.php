<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organizer;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use http\Env\Request;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizer = Event::with('users')->get();
        if($organizer != null){
            return response()->json(['error' => false, 'data'=>$organizer, 'status'=>200]);
        }else{
            return response()->json(['error'=>false, 'data'=>null, 'status'=>204]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return response()->json(compact('users', 'events'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        $userEvent = new UserEvent([
            'user_id' => $validatedData['user_id'],
            'event_id' => $validatedData['event_id'],
        ]);

        $userEvent->save();

        return response()->json(['message' => 'UserEvent created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $organizer = Organizer::find($id);
        if ($organizer == null){
            return response()->json(['error'=> true, 'message'=> 'Organizer not found', 'status'=>404]);
        }
        else{
            return response()->json(['error'=>false, 'data'=>$organizer, 'status'=>200]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizer $organizer)
    {
        //
    }
}
