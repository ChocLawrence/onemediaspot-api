<?php

namespace App\Http\Controllers;

use App\Models\StatusHistory;
use App\Models\Status;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class StatusHistoryController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatusHistories(Request $request){

        try{
            $status_h_query = StatusHistory::with(['user','service']);

            if($request->keyword){
                $status_h_query->where('note','LIKE','%'.$request->keyword.'%');
            }

            if($request->status_id){
                $status_h_query->whereHas('status',function($query) use($request){
                    $query->where('slug',$request->status);
                });
            }

            if($request->service_id){
                $status_h_query->where('service_id',$request->service_id);
            }

            if($request->user_id){
                $status_h_query->where('user_id',$request->user_id);
            }

            if($request->sortBy && in_array($request->sortBy,['id','created_at'])){
                $sortBy = $request->sortBy;
            }else{
                $sortBy = 'created_at';
            }

            if($request->sortOrder && in_array($request->sortOrder,['asc','desc'])){
                $sortOrder = $request->sortOrder;
            }else{
                $sortOrder = 'desc';
            }

           
            $histories = $status_h_query->orderBY($sortBy,$sortOrder)->get();
  
            return $this->successResponse($histories);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getStatusHistory($id) {

        try{
            $status= StatusHistory::where('id', $id)->get();
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
    public function addStatusHistory(Request $request)
    {
        try{
            
            $validator = $this->validateStatusHistory();
            if($validator->fails()){
              return $this->errorResponse($validator->messages(), 422);
            }

            $status=new StatusHistory();
            $status->note= $request->note;
            $status->status_id= $request->status_id;

            if($request->service_id){
                $status->service_id= $request->service_id;
            }

            if($request->advert_id){
                $status->advert_id= $request->advert_id;
            }


            if($request->institution_id){
                $status->institution_id= $request->institution_id;
            }

            if($request->institution_access_id){
                $status->institution_access_id= $request->institution_access_id;
            }
          
            if($request->user_id){
                $status->user_id= $request->user_id;
            }
          
            $status->save();

            return $this->successResponse($status,"Saved successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }



    public function validateStatusHistory(){
        return Validator::make(request()->all(), [
            'note' => 'required|string|max:100',
            'status_id' => 'required|exists:statuses,id',
            'service_id' => 'nullable|exists:services,id',
            'advert_id' => 'nullable|exists:adverts,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'institution_access_id' => 'nullable|exists:institution_accesses,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
    }
}
