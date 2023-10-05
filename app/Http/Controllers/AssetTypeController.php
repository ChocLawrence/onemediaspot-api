<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Auth;


class AssetTypeController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAssetTypes(){

        try{
            $assetTypes= AssetType::latest()->get();
            return $this->successResponse($assetTypes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
       
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAssetType($id) {

        try{
            $assetType= AssetType::where('id', $id)->firstOrFail();
            return $this->successResponse($assetType);
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
    public function addAssetType(Request $request)
    {

        try{

            $validator = $this->validateAssetType();
            if($validator->fails()){
              return $this->errorResponse($validator->messages(), 422);
            }


            if (Auth::check())
            {
                $id = Auth::id();
            }

            $assetType= new AssetType();
            $assetType->name= $request->name;
            $assetType->description= $request->description;
            $assetType->created_by = $id;
            $assetType->save();

            return $this->successResponse($assetType,"Saved successfully", 200);

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
    public function updateAssetType(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $request->headers->set('Content-Type', '');

            $validator = $this->validateUpdateAssetType();
            if($validator->fails()){
              return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }


            if($request->name){
              $assetType->name = $request->name;
            }

            if($request->description){
              $assetType->description= $request->description;
            }

            $assetType->created_by = $id;
            $assetType->save();

            return $this->successResponse($assetType);
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
    public function deleteAssetType($id)
    {
        try{
            $assetType = AssetType::find($id);
            $assetType->delete();

            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function validateAssetType(){
        return Validator::make(request()->all(), [
           'name'=>'required|unique:asset_types',
           'description'=>'required|max:200'
        ]);
    }

    public function validateUpdateAssetType(){
        return Validator::make(request()->all(), [
           'name'=>'nullable|unique:asset_types',
           'description'=>'required|max:200'
        ]);
    }
}
