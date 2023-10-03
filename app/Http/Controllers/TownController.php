<?php

namespace App\Http\Controllers;

use App\Models\Town;
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


class TownController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTowns(){
        try{
            $towns= Town::latest()->get();
            return $this->successResponse($towns);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTown($id) {

        try{
            $town= Town::where('id', $id)->get();
            return $this->successResponse($town);
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
    public function addTown(Request $request)
    {
        try{
            
            $validator = $this->validateTown();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $town=new Town();
            $town->name= $request->name;
            $town->abbr= $request->abbr;   
            $town->city_id= $request->city_id;
            $town->region_id= $request->region_id;
            $town->country_id= $request->country_id;
            $town->save();

            return $this->successResponse($town,"Saved successfully", 200);

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
    public function updateTown(Request $request, $id)
    {

        try{

            $validator = $this->validateTown();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $town=Town::findOrFail($id);

            if($request->name){
                $town->name = $request->name;
            }

            if($request->abbr){
                $town->abbr= $request->abbr;
            }

            if($request->city_id){
                $town->city_id= $request->city_id;
            }

            if($request->region_id){
                $town->region_id= $request->region_id;
            }

            if($request->country_id){
                $town->country_id= $request->country_id;
            }

            $town->save();

            return $this->successResponse($town,"Updated successfully", 200);

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
    public function deleteTown($id)
    {
        try{

            Town::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateTown(){
        return Validator::make(request()->all(), [
            'name'  => 'required|string|max:100', 
            'abbr' => 'nullable|string|max:300', 
            'city_id' => 'nullable|exists:cities,id',
            'region_id' => 'nullable|exists:regions,id',
            'country_id' => 'required|exists:countries,id'
        ]);
    }

}
