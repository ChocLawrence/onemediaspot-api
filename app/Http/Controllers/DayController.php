<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class DayController extends Controller
{

    use ApiResponser;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDays(){
        try{
            $days= Day::latest()->get();
            return $this->successResponse($days);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDay($id) {

        try{
            $day= Day::where('id', $id)->get();
            return $this->successResponse($day);
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
    public function addDay(Request $request)
    {
        try{
            $validator = $this->validateDay();
            if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
            }

            $day=new Day();
            $day->name= $request->name;
            $day->day_of_week= $request->day_of_week;
            $abbr = substr($request->name, 0, 2);
            $day->abbr= $abbr;
            $day->save();

            return $this->successResponse($day,"Saved successfully", 200);

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
    public function updateDay(Request $request, $id)
    {

        try{

            if(count($request->all()) == 0){
                return $this->errorResponse("Nothing to update.Pass fields", 404);  
            }

            $validator = $this->validateDay();
            if($validator->fails()){
               return $this->errorResponse($validator->messages(), 422);
            }

            $day=Day::findOrFail($id);
        
            $day->name=$request->name; 
            $abbr = substr($request->name, 0, 2);
            $day->abbr= $abbr; 
            $day->day_of_week= $request->day_of_week;
            $day->save();

            return $this->successResponse($day,"Updated successfully", 200);

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
    public function deleteDay($id)
    {
        try{

            Day::findOrFail($id)->delete();
            return $this->successResponse(null,"Deleted successfully", 200);

        }catch(\Exception $e){
            return $this->errorResponse( $e->getMessage(), 404);
        }
    }

    public function validateDay(){
        return Validator::make(request()->all(), [
            'day_of_week' => 'required|string|min:1|max:7',
            'name' => 'required|string|max:10'
        ]);
    }
}
