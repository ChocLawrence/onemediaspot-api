<?php

namespace App\Http\Controllers;

use App\Models\PlanType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PlanTypeController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPlanTypes(){
        try{
            $planTypes= PlanType::latest()->get();
            return $this->successResponse($planTypes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPlanType($id) {

        try{
            $planType= PlanType::where('id', $id)->get();
            return $this->successResponse($planType);
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
    public function addPlanType(Request $request)
    {
        try{
            
            $validator = $this->validatePlanType();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $planType=new PlanType();
            $planType->name= $request->name;
            $planType->slug= Str::slug($request->name);
            $planType->description= $request->description;
            $planType->save();

            return $this->successResponse($planType,"Saved successfully", 200);

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
    public function updatePlanType(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validatePlanType();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $planType=PlanType::findOrFail($id);
        
            if($request->name){
              $planType->name=$request->name;  
              $planType->slug=Str::slug($request->name);
            }
           
            if($request->description){
              $planType->description = $request->description;
            }

            $planType->save();

            return $this->successResponse($planType,"Updated successfully", 200);

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
    public function deletePlanType($id)
    {
        try{

            PlanType::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validatePlanType(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:20',
            'description' => 'nullable|string|max:100'
        ]);
    }
}
