<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class NewsController extends Controller
{
    
    
    public function index(){
        $data = Category::get();
        return view('news.index', compact('data'));
    }

    public function getData(Request $request) {

        $id = $request->id;

        if($id) {
            $data = News::where('id', $id)->first();
        } else {
            $data = News::with('category')->get();
            // $data = News::get();
            
            $no = 0;
            foreach($data as $d) {
                $d->no = $no+=1;
            }
        }

        $result = [
            "data" => $data
        ];

        return response()->json($result);

    }

    public function createData(Request $request){

       
        $check= News::where('title', $request->title)->first();
        if($check){
            return $this->result('Category alredy exist');

        }

        $data = new News;
        $data->id_category= $request->id_category;
        $data->title= $request->title;
        $data->quantity= $request->quantity;
        $data->save();

        
        return $this->result('Success Create', true, $data);


}

//     public function createData(Request $request){

//         $result=[
//                 "status" => false,
//                 "data" => null,
//                 "message"=> '',
//                 "newToken" => csrf_token()
//         ];

//         $check= News::where('title', $request->title)->first();
//         if($check){
//             $result['message']="Data already exist";
//         return response()->json($result);

//         }

//         $data = new News;
//         $data->id_category= $request->id_category;
//         $data->title= $request->title;
//         $data->quantity= $request->quantity;
//         $data->save();

//         $result['newToken'] = csrf_token();
//         $result['status'] = true;
//         $result['data'] = $data;
//         $result['message'] = "success create data";

//           return response()->json($result);


// }

public function updateData(Request $request, $id) {
    $result = [
        'status' => false,
        'message' => '',
        'data' => null,
        'newToken' => csrf_token()
    ];

    $check = News::where('title', $request->title)->where('id', '!=', $id)->first();

    if ($check) {
        $result['message'] = "Title already exist";
        return response()->json($result);
    }

    $data = News::where('id', $id)->first();
    $data->title = $request->title;
    $data->id_category = $request->id_category;
    $data->quantity = $request->quantity;
    $data->save();

    $result['status'] = true;
    $result['message'] = 'Update data successfuly';
    $result['data'] = $data;

    return response()->json($result);

}

public function deleteData($id) {

    $result = [
        'status' => false,
        'message' => '',
        'data' => null,
        'newToken' => csrf_token()
    ];

    $data = News::where('id', $id)->first();

    if(!$data) {
        $result['message'] = 'Data not found';
        return response()->json($result);
    }

    $data->delete();

    $result['status'] = true;
    $result['message'] = 'Delete has been deleted';
    // $result['data'] = $data;

    return response()->json($result);

}

    public function restoreData(){
        $restore = News::where('id', '10')->onlyTrashed()->restore();
        if($restore){
            $result = [
                'message' => 'success restore data',
                'data' => $restore
            ];
            return response()-> json($result);
        }
    }

    public function deletePermanentData(){
        $delete = News::where('id', '10')->forceDelete();
        if($delete){
            $result = [
                'message' => 'succes delete permanent data',
                'data' => $delete
            ];
            return response()->json($result);
        }
    }

}
