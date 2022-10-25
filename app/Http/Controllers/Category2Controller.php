<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Redirect;

class Category2Controller extends Controller
{
    public function index(){
        return view('category2.index');
    }

    public function getData(Request $request){

        $id = $request->id;

        if($id){
            $data = Category::where('id', $id)->first();
        }else {
            $data=Category::get();
            $no=0;

            foreach($data as $d){
                $d->no = $no+=1;
            }
        }

      
        $result = [
         "data" =>$data
        ];
        return response()->json($result);
    }

    public function createData(Request $request){

        $result=[
                "status" => true,
                "data" => true,
                "message"=> '',
                "newToken" =>csrf_token()
        ];

        $check= Category::where('name', $request->name)->first();
        if($check){
            $result['message']="Category alread exist";
        return response()->json($result);

        }

        $data = new Category;
        $data -> name= $request->name;
        $data -> quantity= $request->quantity;
        $data -> save();

        $result['newToken'] = csrf_token();
        $result['status'] = true;
        $result['data'] = $data;
        $result['message'] = "success create data";

        // cara ke 2 :
        // $result = [
        //     'status' => true,
        //     'data' => $data,
        //     'message' => "success create data"
        // ]

        return response()->json($result);


    }

    public function updateData(Request $request, $id){
        $result = [
            'status' => false,
            'data' => null,
            'message' => '',
            'newToken' => csrf_token()
        ];

        $check = Category::where('name', $request->name)
        ->where('id','!=', $id)->first();

        if($check){
            $result['message']= 'Category name already exist';
            return response()->json($result);
        }

        $data = Category::where('id', $id)->first();

        if(!$data){
            $result['message']=" data not found";
            return response()->json($result);

        }
        $data->name = $request->name;
        $data->quantity = $request->quantity;
        $data->status_active = $request-> status_active;
        $data->update();

        $result['status']= true;
        $result['data']= $data;
        $result['message']= "Success update";

        return response()->json($result);
    }

    public function deleteData($id) {
        $result = [
            'status' => false,
            'data' => null,
            'message' => '',
            'newToken' => csrf_token()
        ];

        $data = Category::where('id', $id)->first();

        if(!$data) {
            $result['message'] = "Category not found";
            return response()->json($result);
        }

        $data->delete();

        $result['status'] = true;
        $result['message'] = "Category has been deleted";

        return response()->json($result);
    }
    public function updateStatus($id)
    {
        $data = Category::where('id', $id)->first();

        if(!$data){
            return $this->result('Data not found');
        }

        $status = 'ACTIVE';

        if($data->status_active=='ACTIVE'){
            $status = 'NONACTIVE';
        }else{
            $status = 'ACTIVE';
        }

        $data->status_active = $status;
        $data->update();

        return $this->result("Category $data->name $data->status_active !", true, $data);
    }

}

