<?php

namespace App\Http\Controllers;

use App\Models\InstitutionAccess;
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


class InstitutionAccessController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getInstitutionAccesses(){
        try{
            $institutionAccesses= InstitutionAccess::latest()->get();
            return $this->successResponse($institutionAccesses);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getInstitutionAccess($id) {

        try{
            $institutionAccess= InstitutionAccess::where('id', $id)->get();
            return $this->successResponse($institutionAccess);
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
    public function addInstitutionAccess(Request $request)
    {
        try{
            $validator = $this->validateInstitutionAccess();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $pendingStatus = Status::where('name', 'pending')->firstOrFail();

            $institutionAccess=new InstitutionAccess();
            $institutionAccess->title= $request->title;
            $institutionAccess->email= $request->email;  
            $institutionAccess->phone= $request->phone;  
            $institutionAccess->user_id= $request->user_id;
            $institutionAccess->service_id= $request->service_id;
            $institutionAccess->status_id= $pendingStatus->id;
            $institutionAccess->institution_id= $request->institution_id;
            $institutionAccess->save();

            return $this->successResponse($institutionAccess,"Saved successfully", 200);

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
    public function updateInstitutionAccess(Request $request, $id)
    {

        try{

            $validator = $this->validateInstitutionAccess();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $institutionAccess=InstitutionAccess::findOrFail($id);

            if($request->title){
                $institutionAccess->title = $request->title;
            }

            if($request->email){
                $institutionAccess->email= $request->email;
            }

            if($request->phone){
                $institutionAccess->phone= $request->phone;
            }

            if($request->user_id){
                $institutionAccess->user_id= $request->user_id;
            }

            if($request->service_id){
                $institutionAccess->service_id= $request->service_id;
            }

            if($request->status_id){
                $institutionAccess->status_id= $request->status_id;
            }

            if($request->institution_id){
                $institutionAccess->institution_id= $request->institution_id;
            }

            $institutionAccess->save();

            return $this->successResponse($institutionAccess,"Updated successfully", 200);

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
    public function deleteInstitutionAccess($id)
    {
        try{

            InstitutionAccess::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateInstitutionAccess(){
        return Validator::make(request()->all(), [
            'title'  => 'required|string|max:50', 
            'email' => 'required|string',
            'phone' => 'string|min:7|max:20',
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'status_id' => 'nullable|exists:statuses,id',
            'institution_id' => 'nullable|exists:institutions,id',
        ]);
    }

}
