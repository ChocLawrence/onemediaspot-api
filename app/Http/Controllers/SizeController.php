<?php

namespace App\Http\Controllers;

use App\Models\Size;
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


class SizeController extends Controller
{
    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSizes(){
        try{
            $sizes= Size::latest()->get();
            return $this->successResponse($sizes);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSize($id) {

        try{
            $size= Size::where('id', $id)->get();
            return $this->successResponse($size);
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
    public function addSize(Request $request)
    {
        try{
            $validator = $this->validateSize();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            if (Auth::check())
            {
                $id = Auth::id();
            }

            $size=new Size();
            $size->name= $request->name;
            $slug= Str::slug($request->name);
            $size->slug= $slug;
            $size->description= $request->description;
            $size->unit_id= $request->unit_id;
            $size->slot_type_id= $request->slot_type_id;
            $size->created_by= $id;
            $size->save();

            return $this->successResponse($size,"Saved successfully", 200);

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
    public function updateSize(Request $request, $id)
    {

        try{

            $validator = $this->validateSize();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }


            if (Auth::check())
            {
                $id = Auth::id();
            }

            $size=Size::findOrFail($id);

            if($request->name){
                $slug = Str::slug($request->name);
                $size->name = $request->name;
                $size->slug = $slug;
            }
  

            if($request->description){
                $size->description= $request->description;
            }

            if($request->unit_id){
                $size->unit_id= $request->unit_id;
            }

            if($request->slot_type_id){
                $size->slot_type_id= $request->slot_type_id;
            }

            $size->created_by= $id;
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
    public function deleteSize($id)
    {
        try{

            Size::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateSize(){
        return Validator::make(request()->all(), [
            'name'  => 'required|string|max:100', 
            'description' => 'nullable|string|max:300',
            'unit_id' => 'required|exists:units,id',
            'slot_type_id' => 'nullable|exists:slot_types,id'
        ]);
    }

}
