<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataHealth;
class DataHealthController extends Controller
{
    //
    public function list($facility_name){
        // dd($facility_name);
        $data = DataHealth::where('facility_name', $facility_name)->get();
        if ($data->count() == 0) return response()->json(['message' => 'No record found.']);
        return response()->json(['data' => $data]);
    }
    public function create(Request $request){        
        $this->validate($request, [
            'facility_name' => 'required',
            'score'=>'required',
            'grade' => 'required',
        ]);
        $data = new DataHealth();
        $data->facility_name = $request->facility_name;
        $data->grade = $request->grade;
        $data->score = $request->score;
        $data->save();
        return response()->json(['message' => 'success', 'data' => $data]);
    }
    public function update(Request $request){
        $this->validate($request, [
            'facility_name' => 'required',
            'grade' => 'required',
        ]);
        $dataHealths = DataHealth::where('facility_name', $request->facility_name)->get();
        if ($dataHealths->count() == 0) return response()->json(['message' => 'No record found.']);
        foreach ($dataHealths as $data) {
            $data->grade = $request->grade;
            $data->save();
        }
        return response()->json(['message' => 'success']);
    }
    public function delete(Request  $request){
        $this->validate($request, [
            'facility_name' => 'required',
            'grade' => 'required',
        ]);
        $dataHealths = DataHealth::where('facility_name', $request->facility_name)->where('grade', $request->grade)->get();
        if ($dataHealths->count() == 0) return response()->json(['message' => 'No record found.']);
        foreach ($dataHealths as $data) {
            $data->delete();
        }
        return response()->json(['message' => 'success']);
    }
    public function min(){
        $min = DataHealth::where('score', DataHealth::min('score'))->get();
        return response()->json(['min' => $min]);
    }

    public function countGrade($grade){
        $result = DataHealth::where('grade', $grade)->count();
        if ($result == 0) return response()->json(['message' => 'No record found']);
        return response()->json(['result' => $result]);

    }
}
