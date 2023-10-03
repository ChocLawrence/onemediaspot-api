<?php

namespace App\Http\Controllers;

use App\Models\City;
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


class CityController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCities(){
        try{
            $cities= City::latest()->get();
            return $this->successResponse($cities);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCity($id) {

        try{
            $city= City::where('id', $id)->get();
            return $this->successResponse($city);
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
    public function addCity(Request $request)
    {
        try{
            $validator = $this->validateCity();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $city=new City();
            $city->name= $request->name;
            $city->abbr= $request->abbr;  
            $city->region_id= $request->region_id;
            $city->country_id= $request->country_id;
            $city->save();

            return $this->successResponse($city,"Saved successfully", 200);

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
    public function updateCity(Request $request, $id)
    {

        try{

            $validator = $this->validateCity();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $city=City::findOrFail($id);

            if($request->name){
                $city->name = $request->name;
            }

            if($request->abbr){
                $city->abbr= $request->abbr;
            }

            if($request->region_id){
                $city->region_id= $request->region_id;
            }

            if($request->country_id){
                $city->country_id= $request->country_id;
            }

            $city->save();

            return $this->successResponse($city,"Updated successfully", 200);

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
    public function deleteCity($id)
    {
        try{

            City::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateCity(){
        return Validator::make(request()->all(), [
            'name'  => 'required|string|max:100', 
            'abbr' => 'nullable|string|max:300',
            'region_id' => 'nullable|exists:regions,id',
            'country_id' => 'required|exists:countries,id'
        ]);
    }

}
