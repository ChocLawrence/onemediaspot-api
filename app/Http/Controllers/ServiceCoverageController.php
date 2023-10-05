<?php

namespace App\Http\Controllers;

use App\Models\ServiceCoverage;
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


class ServiceCoverageController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getServiceCoverages(){
        try{
            $serviceCoverages= ServiceCoverage::latest()->get();
            return $this->successResponse($serviceCoverages);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getServiceCoverage($id) {

        try{
            $serviceCoverage= ServiceCoverage::where('id', $id)->get();
            return $this->successResponse($serviceCoverage);
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
    public function addServiceCoverage(Request $request)
    {
        try{
            $validator = $this->validateServiceCoverage();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $serviceCoverage=new ServiceCoverage();
            $serviceCoverage->advert_count= $request->advert_count;
            $serviceCoverage->institution_id= $request->institution_id;
            $serviceCoverage->service_id= $request->service_id;
            $serviceCoverage->plan_id= $request->plan_id;  
            $serviceCoverage->created_by= $id;
            $serviceCoverage->save();

            return $this->successResponse($serviceCoverage,"Saved successfully", 200);

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
    public function updateServiceCoverage(Request $request, $id)
    {

        try{

            $validator = $this->validateServiceCoverage();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $serviceCoverage=ServiceCoverage::findOrFail($id);

            if($request->advert_count){
                $serviceCoverage->advert_count = $request->advert_count;
            }

            if($request->institution_id){
                $serviceCoverage->institution_id= $request->institution_id;
            }

            if($request->service_id){
                $serviceCoverage->service_id= $request->service_id;
            }

            if($request->plan_id){
                $serviceCoverage->plan_id= $request->plan_id;
            }

            $serviceCoverage->created_by = $id;
            $serviceCoverage->save();

            return $this->successResponse($serviceCoverage,"Updated successfully", 200);

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
    public function deleteServiceCoverage($id)
    {
        try{

            ServiceCoverage::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateServiceCoverage(){
        return Validator::make(request()->all(), [
            'advert_count'  => 'required|string', 
            'institution_id' => 'nullable|exists:institutions,id',
            'service_id' => 'required|exists:services,id',
            'plan_id' => 'required|exists:plans,id'
        ]);
    }

}
