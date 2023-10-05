<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getUnits(){
        try{
            $units= Unit::latest()->get();
            return $this->successResponse($units);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getUnit($id) {

        try{
            $unit= Unit::where('id', $id)->get();
            return $this->successResponse($unit);
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
    public function addUnit(Request $request)
    {
        try{
            $validator = $this->validateUnit();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $unit=new Unit();
            $unit->name= $request->name;
            $unit->slug= Str::slug($request->name);
            $unit->abbr= $request->abbr;
            $unit->save();

            return $this->successResponse($unit,"Saved successfully", 200);

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
    public function updateUnit(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validateUnit();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $unit=Unit::findOrFail($id);
        
            if($request->name){
              $unit->name=$request->name;  
              $unit->slug=Str::slug($request->name);
            }
           
            if($request->abbr){
              $unit->abbr = $request->abbr;
            }

            $unit->save();

            return $this->successResponse($unit,"Updated successfully", 200);

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
    public function deleteUnit($id)
    {
        try{

            Unit::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateUnit(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:20',
            'abbr' => 'nullable|string|max:100'
        ]);
    }
}
