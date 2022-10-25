<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(){
        $data = News::get();
        return view('comment.index', compact('data'));
    }

    public function getData(Request $request) {

        $id = $request->id;

        if($id) {
            $data = Comment::where('id', $id)->first();
        } else {
            $data = Comment::with('news')->get();
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

       
        $check= Comment::where('nama', $request->nama)->first();
        if($check){
            return $this->result('Category alredy exist');

        }

        $data = new Comment;
        $data->nama= $request->nama;
        $data->like= $request->like;
        $data->comment= $request->comment;
        $data->save();

        
        return $this->result('Success Create', true, $data);


}
}
