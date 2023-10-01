<?php

namespace App\Http\Controllers;

use App\Models\Frequency;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class FrequencyController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getFrequencies(){
        try{
            $frequencies= Frequency::latest()->get();
            return $this->successResponse($frequencies);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getFrequency($id) {

        try{
            $status= Frequency::where('id', $id)->get();
            return $this->successResponse($status);
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
    public function addFrequency(Request $request)
    {
        try{
            $validator = $this->validateFrequency();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $status=new Frequency();
            $status->name= $request->name;
            $status->slug= Str::slug($request->name);
            $status->description= $request->description;
            $status->save();

            return $this->successResponse($status,"Saved successfully", 200);

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
    public function updateFrequency(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validateFrequency();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $status=Frequency::findOrFail($id);
        
            if($request->name){
              $status->name=$request->name;  
              $status->slug=Str::slug($request->name);
            }
           
            if($request->description){
              $status->description = $request->description;
            }

            $status->save();

            return $this->successResponse($status,"Updated successfully", 200);

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
    public function deleteFrequency($id)
    {
        try{

            Frequency::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateFrequency(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:100'
        ]);
    }
}
