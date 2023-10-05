<?php

namespace App\Http\Controllers;

use App\Models\Occurence;
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


class OccurenceController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getOccurences(){
        try{
            $occurences= Occurence::latest()->get();
            return $this->successResponse($occurences);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getOccurence($id) {

        try{
            $occurence= Occurence::where('id', $id)->get();
            return $this->successResponse($occurence);
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
    public function addOccurence(Request $request)
    {
        try{
            $validator = $this->validateOccurence();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $occurence=new Occurence();
            $occurence->day_id= $request->day_id;
            $occurence->frequency_id= $request->frequency_id;
            $occurence->slot_type_id= $request->slot_type_id;
            $occurence->created_by= $id;
            $occurence->save();

            return $this->successResponse($occurence,"Saved successfully", 200);

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
    public function updateOccurence(Request $request, $id)
    {

        try{

            $validator = $this->validateOccurence();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }


            $occurence=Occurence::findOrFail($id);

            if($request->day_id){
                $occurence->day_id= $request->day_id;
            }

            if($request->frequency_id){
                $occurence->frequency_id= $request->frequency_id;
            }

            if($request->slot_type_id){
                $occurence->slot_type_id= $request->slot_type_id;
            }

            $occurence->created_by= $id;

            $occurence->save();

            return $this->successResponse($occurence,"Updated successfully", 200);

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
    public function deleteOccurence($id)
    {
        try{

            Occurence::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }
    

    public function validateOccurence(){
        return Validator::make(request()->all(), [
            'day_id' => 'required|exists:days,id',
            'frequency_id' => 'required|exists:frequencies,id',
            'slot_type_id' => 'required|exists:slot_types,id'
        ]);
    }

}
