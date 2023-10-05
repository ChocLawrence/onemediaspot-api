<?php

namespace App\Http\Controllers;

use App\Models\Follower;
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


class FollowerController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCities(){
        try{
            $cities= Follower::latest()->get();
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

    public function getFollower($id) {

        try{
            $follower= Follower::where('id', $id)->get();
            return $this->successResponse($follower);
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
    public function addFollower(Request $request)
    {
        try{
            $validator = $this->validateFollower();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $follower=new Follower(); 
            $follower->service_id= $request->service_id;
            $follower->institution_id= $request->institution_id;
            $follower->user_id= $id;
            $follower->save();

            return $this->successResponse($follower,"Saved successfully", 200);

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
    public function deleteFollower($id)
    {
        try{

            Follower::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateFollower(){
        return Validator::make(request()->all(), [
            'service_id' => 'nullable|exists:services,id',
            'institution_id' => 'nullable|exists:institutions,id',
        ]);
    }

}
