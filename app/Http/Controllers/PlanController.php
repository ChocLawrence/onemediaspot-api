<?php

namespace App\Http\Controllers;

use App\Models\Plan;
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


class PlanController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPlans(){
        try{
            $plans= Plan::latest()->get();
            return $this->successResponse($plans);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPlan($id) {

        try{
            $plan= Plan::where('id', $id)->get();
            return $this->successResponse($plan);
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
    public function addPlan(Request $request)
    {
        try{
            $validator = $this->validatePlan();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $pendingStatus = Status::where('name', 'pending')->firstOrFail();

            $plan=new Plan();
            $plan->name= $request->name;
            $plan->description= $request->description;  
            $plan->duration= $request->duration;  
            $plan->amount= $request->amount;  
            $plan->status_id= $pendingStatus->id;
            $plan->institution_id= $request->institution_id;
            $plan->created_by= $id;
            $plan->save();

            return $this->successResponse($plan,"Saved successfully", 200);

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
    public function updatePlan(Request $request, $id)
    {

        try{

            $validator = $this->validatePlan();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }


            if (Auth::check())
            {
                $id = Auth::id();
            }

            $plan=Plan::findOrFail($id);

            if($request->name){
                $plan->name = $request->name;
            }

            if($request->description){
                $plan->description= $request->description;
            }

            if($request->duration){
                $plan->duration= $request->duration;
            }

            if($request->amount){
                $plan->amount= $request->amount;
            }

            if($request->status_id){
                $plan->status_id= $request->status_id;
            }

            if($request->institution_id){
                $plan->institution_id= $request->institution_id;
            }

            
            $plan->created_by= $id;
            $plan->save();

            return $this->successResponse($plan,"Updated successfully", 200);

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
    public function deletePlan($id)
    {
        try{

            Plan::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validatePlan(){
        return Validator::make(request()->all(), [
            'name'  => 'required|string|max:20', 
            'description' => 'nullable|string|max:100',
            'duration' => 'nullable|numeric|min:31|max:365',
            'amount' => 'nullable|string|max:100',
            'status_id' => 'nullable|exists:statuses,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'created_by' => 'required|exists:users,id'
        ]);
    }

}
