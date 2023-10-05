<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
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


class UserRoleController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCities(){
        try{
            $userRoles= UserRole::latest()->get();
            return $this->successResponse($userRoles);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getUserRole($id) {

        try{
            $userRole= UserRole::where('id', $id)->get();
            return $this->successResponse($userRole);
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
    public function addUserRole(Request $request)
    {
        try{
            $validator = $this->validateUserRole();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $userRole=new UserRole(); 
            $userRole->role_id= $request->role_id;
            $userRole->user_id= $request->user_id;
            $userRole->save();

            return $this->successResponse($userRole,"Saved successfully", 200);

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
    public function updateUserRole(Request $request, $id)
    {

        try{

            $validator = $this->validateUserRole();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $userRole=UserRole::findOrFail($id);

            if($request->user_id){
                $size->user_id= $request->user_id;
            }

            if($request->role_id){
                $size->role_id= $request->role_id;
            }

            $size->save();

            return $this->successResponse($size,"Updated successfully", 200);

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
    public function deleteUserRole($id)
    {
        try{

            UserRole::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateUserRole(){
        return Validator::make(request()->all(), [
            'role_id' => 'nullable|exists:roles,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
    }

}
