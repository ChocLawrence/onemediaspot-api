<?php

namespace App\Http\Controllers;

use App\Models\ValidAssetType;
use App\Models\User;
use App\Models\Service;
use App\Models\Demand;
use App\Models\Status;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class ValidAssetTypeController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getValidAssetTypes(){
        try{
            $validAssetTypes= ValidAssetType::latest()->get();
            return $this->successResponse($validAssetTypes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getValidAssetType($id) {

        try{
            $validAssetType= ValidAssetType::where('id', $id)->get();
            return $this->successResponse($validAssetType);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addValidAssetType(Request $request)
    {
        try{
            $validator = $this->validateValidAssetType();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $validAssetType=new ValidAssetType(); 
            $validAssetType->asset_type_id= $request->asset_type_id;
            $validAssetType->slot_type_id= $request->slot_type_id;
            $validAssetType->created_by= $id;
            $validAssetType->save();

            return $this->successResponse($validAssetType,"Saved successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }


      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateValidAssetType(Request $request, $id)
    {

        try{

            $validator = $this->validateSize();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }


            if (Auth::check())
            {
                $id = Auth::id();
            }

            $validAssetType=Size::findOrFail($id);

            if($request->asset_type_id){
                $validAssetType->asset_type_id= $request->asset_type_id;
            }

            if($request->slot_type_id){
                $validAssetType->slot_type_id= $request->slot_type_id;
            }

            $validAssetType->created_by= $id;
            $validAssetType->save();

            return $this->successResponse($validAssetType,"Updated successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
        
        
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteValidAssetType($id)
    {
        try{

            ValidAssetType::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateValidAssetType(){
        return Validator::make(request()->all(), [
            'asset_type_id' => 'nullable|exists:asset_types,id', 
            'slot_type_id' => 'nullable|exists:slot_types,id',
        ]);
    }

}
