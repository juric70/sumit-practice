<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::all();
        if($company != null){
            return response()->json(['error' => false, 'data'=>$company, 'status'=>200]);
        }else{
            return response()->json(['error'=>false, 'data'=>null, 'status'=>204]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $company_check = Company::where('name', 'like', $request->input('name'))->exists();
        if (!$company_check) {
            $validatedDate = $request->validate([
                'name'=>'required|string',
                'mail'=>'required|string',
                'tel_number'=>'required|string',
                'address'=>'required|string',
                'user_id' => 'required|exists:users,id',
                'city_id' => 'exists:cities,id',
            ]);
            $company = new Company([
                'name' => $request->input('name'),
                'about_company' => $request->input('about_company'),
                'mail' => $request->input('mail'),
                'tel_number' => $request->input('tel_number'),
                'address' => $request->input('address'),
                'city_id' => $validatedDate['city_id'],
                'user_id' => $validatedDate['user_id']
            ]);
            $company->save();
            return response()->json(['error' => false, 'message' => 'Company successfully created', 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'Name already exists!', 'status' => 406]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $company = Company::find($id);
        if($company!=null){
            return response()->json(['error'=>false, 'data'=>$company, 'status'=>200]);
        }else{
            return response()->json(['error'=>true, 'message'=>'Company does not exist!', 'status'=>404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $company_check = Company::where('name', 'like', $request->input('name'))->where('id', '<>', $id)->count();
        if ($company_check>0){
            return response()->json(['error'=>true, 'message'=>'Name already exists!', 'status'=>406]);
        }else{
            try {
                $company = Company::find($id);
                $validatedDate = $request->validate([
                    'name'=>'required|string',
                    'mail'=>'required|string',
                    'tel_number'=>'required|string',
                    'address'=>'required|string',
                    'user_id' => 'required|exists:users,id',
                    'city_id' => 'exists:cities,id',
                ]);
                $updatedData = [
                    'name' => $validatedDate['name'],
                    'about_company' => $request->input('about_company'),
                    'mail' => $validatedDate['mail'],
                    'tel_number' =>$validatedDate['tel_number'],
                    'address' => $validatedDate['address'],
                    'city_id' => $validatedDate['city_id'],
                    'user_id' => $validatedDate['user_id']
                ];
                $company->update($updatedData);
                return response()->json(['error' => false, 'message' => 'Company successfully updated!', 'data' => $company, 'status' => 200]);

            }catch (\Exception $e){
                Log::error("Exception: " . $e->getMessage());
                return response()->json(['error'=> true,'message' => 'Something went wrong!', 'status'=>500]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            $company = Company::find($id);
            if($company != null){
                $company->delete();
                return response()->json(['error'=>false, 'message'=>'Company successfully deleted!', 'status'=>200]);
            }else{
                return response()->json(['error'=> true, 'message'=> 'Company does not exist!', 'status'=>404]);
            }
        }catch (Exception $e){
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error'=> true, 'message'=> 'Something went wrong!', 'status'=>500]);
        }
    }
}
