<?php

namespace App\Http\Controllers;

use App\Models\InstitutionType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class InstitutionTypeController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getInstitutionTypes(){
        try{
            $institutionTypes= InstitutionType::latest()->get();
            return $this->successResponse($institutionTypes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getInstitutionType($id) {

        try{
            $institutionType= InstitutionType::where('id', $id)->get();
            return $this->successResponse($institutionType);
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
    public function addInstitutionType(Request $request)
    {
        try{
            $validator = $this->validateInstitutionType();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $institutionType=new InstitutionType();
            $institutionType->name= $request->name;
            $institutionType->slug= Str::slug($request->name);
            $institutionType->description= $request->description;
            $institutionType->save();

            return $this->successResponse($institutionType,"Saved successfully", 200);

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
    public function updateInstitutionType(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validateInstitutionType();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $institutionType=InstitutionType::findOrFail($id);
        
            if($request->name){
              $institutionType->name=$request->name;  
              $institutionType->slug=Str::slug($request->name);
            }
           
            if($request->description){
              $institutionType->description = $request->description;
            }

            $institutionType->save();

            return $this->successResponse($institutionType,"Updated successfully", 200);

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
    public function deleteInstitutionType($id)
    {
        try{

            InstitutionType::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateInstitutionType(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:20',
            'description' => 'nullable|string|max:100'
        ]);
    }
}
