<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;

class TransactionTypeController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTransactionTypes(){
        try{
            $transactionTypes= TransactionType::latest()->get();
            return $this->successResponse($transactionTypes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTransactionType($id) {

        try{
            $transactionType= TransactionType::where('id', $id)->get();
            return $this->successResponse($transactionType);
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
    public function addTransactionType(Request $request)
    {
        try{
            $validator = $this->validateTransactionType();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $userId = Auth::id();
            }

            $transactionType=new TransactionType();
            $transactionType->name= $request->name;
            $transactionType->slug= Str::slug($request->name);
            $transactionType->description= $request->description;
            $transactionType->created_by= $userId;
            $transactionType->save();

            return $this->successResponse($transactionType,"Saved successfully", 200);

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
    public function updateTransactionType(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validateTransactionType();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $userId = Auth::id();
            }

            $transactionType=TransactionType::findOrFail($id);
        
            if($request->name){
                $transactionType->name=$request->name;  
                $transactionType->slug=Str::slug($request->name);
            }

            if($request->description){
                $transactionType->description=$request->description; 
            }

            $transactionType->created_by= $userId;
            $transactionType->save();

            return $this->successResponse($transactionType,"Updated successfully", 200);

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
    public function deleteTransactionType($id)
    {
        try{

            TransactionType::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateTransactionType(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:200'
        ]);
    }
}
