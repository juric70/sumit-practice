<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Exception;
use http\Env\Request;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\b;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $role_check = Role::where('name', 'like', $request->input('name'))->exists();
        if(!$role_check){
                $role = new Role(['name'=>$request->input('name'), 'description'=>$request->input('description')]);
                $role->save();
                return response()->json(['error'=> false, 'message'=> 'Role successfully added!', 'status'=>200]);
        }else{
           return response()->json(['error' => true, 'message' => 'A role with this name already exists!', 'status' => 406]);
        }
    }

  /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $role = Role::find($id);
        if($role == null){
            return response()->json(['error'=>true, 'message'=>'Role not found', 'status'=>404]);
        }else{
            return response()->json(['error'=>false, 'data'=>$role, 'status'=>200]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        $role_check = Role::where('name', 'like', $request->input('name'))->where('id', '<>', $id)->count();
        if($role_check >0 ){
            return response()->json(['error'=> true, 'message'=>'Name you want to update in role already exists!', 'status'=>406]);
        }else{
            return $this->saveRole($id, $request);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $role = Role::find($id);
            if($role == null){
                return response()->json(['error'=>true, 'message'=>'Role You want do delete does not exist!', 'status'=>404]);
            }else{
                $role->delete();
                return response()->json(['error'=>false, 'message'=>'Role is successfully deleted!']);
            }
        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true, 'data'=>'', 'message'=> 'Something went wrong!', 'status'=>500]);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRole(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $role = Role::find($id);
            $role->update($request->all());
            return response()->json(['error' => false, 'message' => 'Role is successfully updated!', 'status' => 200]);
        } catch (Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error' => true, 'data' => '', 'message' => 'Something went wrong!', 'status' => 500]);
        }
    }
}
