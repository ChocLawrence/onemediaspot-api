<?php

namespace App\Http\Controllers;

use App\Models\Region;
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


class RegionController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getRegions(){
        try{
            $regions= Region::latest()->get();
            return $this->successResponse($regions);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getRegion($id) {

        try{
            $region= Region::where('id', $id)->get();
            return $this->successResponse($region);
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
    public function addRegion(Request $request)
    {
        try{
            $validator = $this->validateRegion();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $region=new Region();
            $region->name= $request->name;
            $region->abbr= $request->abbr;
            $region->country_id= $request->country_id;
            $region->save();

            return $this->successResponse($region,"Saved successfully", 200);

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
    public function updateRegion(Request $request, $id)
    {

        try{

            $validator = $this->validateRegion();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $region=Region::findOrFail($id);

            if($request->name){
                $region->name = $request->name;
            }

            if($request->abbr){
                $region->abbr= $request->abbr;
            }

            if($request->country_id){
                $region->country_id= $request->country_id;
            }

            $region->save();

            return $this->successResponse($region,"Updated successfully", 200);

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
    public function deleteRegion($id)
    {
        try{

            Region::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateRegion(){
        return Validator::make(request()->all(), [
            'name'  => 'required|string|max:100', 
            'abbr' => 'nullable|string|max:300',
            'country_id' => 'required|exists:countries,id'
        ]);
    }

}
