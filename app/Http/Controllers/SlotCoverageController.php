<?php

namespace App\Http\Controllers;

use App\Models\SlotCoverage;
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


class SlotCoverageController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSlotCoverages(){
        try{
            $slotCoverages= SlotCoverage::latest()->get();
            return $this->successResponse($slotCoverages);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSlotCoverage($id) {

        try{
            $slotCoverage= SlotCoverage::where('id', $id)->get();
            return $this->successResponse($slotCoverage);
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
    public function addSlotCoverage(Request $request)
    {
        try{
            $validator = $this->validateSlotCoverage();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $slotCoverage=new SlotCoverage();
            $slotCoverage->advert_count= $request->advert_count;
            $slotCoverage->institution_id= $request->institution_id;
            $slotCoverage->slot_id= $request->slot_id;
            $slotCoverage->plan_id= $request->plan_id;  
            $slotCoverage->created_by= $id;
            $slotCoverage->save();

            return $this->successResponse($slotCoverage,"Saved successfully", 200);

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
    public function updateSlotCoverage(Request $request, $id)
    {

        try{

            $validator = $this->validateSlotCoverage();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $slotCoverage=SlotCoverage::findOrFail($id);

            if($request->advert_count){
                $slotCoverage->advert_count = $request->advert_count;
            }

            if($request->institution_id){
                $slotCoverage->institution_id= $request->institution_id;
            }

            if($request->slot_id){
                $slotCoverage->slot_id= $request->slot_id;
            }

            if($request->plan_id){
                $slotCoverage->plan_id= $request->plan_id;
            }

            $slotCoverage->created_by = $id;
            $slotCoverage->save();

            return $this->successResponse($slotCoverage,"Updated successfully", 200);

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
    public function deleteSlotCoverage($id)
    {
        try{

            SlotCoverage::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateSlotCoverage(){
        return Validator::make(request()->all(), [
            'advert_count'  => 'required|string', 
            'institution_id' => 'nullable|exists:institutions,id',
            'slot_id' => 'required|exists:services,id',
            'plan_id' => 'required|exists:plans,id'
        ]);
    }

}
