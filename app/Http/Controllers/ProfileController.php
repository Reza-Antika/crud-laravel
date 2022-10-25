<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Redirect;
use App\Models\Profile;

use Auth;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }

    public function getData(){
        $user = Auth::user();
       return response()->json($user);
    }

    public function updateData(Request $request, $id){
        
        $result = [
            'status'=> false,
            'data' => null,
            'message'=> '',
            'newToken' => csrf_token()
        ];
        $user = Profile::where('name', $request->name)->where('id','!=', $id)->first();
        if($user){
            $result['message']='Data user already exist';
            return response()->json($result);
        }

        $user= Profile::where('id', $id)->first();
        if(!$user){
            $result['message'] = "user not found";
            return response()->json($result);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        $result['status'] = true;
        $result['data']= $user;
        $result['message']= "Success update data";
        return response()->json($result);
        
    }

    public function updatePassword(Request $request, $id)
    {
        $result = [
            'status' => false,
            'message' => 'oke',
            'data' => '',
            'newToken' => csrf_token(),
        ];

        $user = Profile::find($request->id);

        if (!Hash::check($request->old_password, $user->password)) {
            $result['message'] = 'Password salah';
            return response()->json($result);
        }
        if ($request->new_password != $request->confirm_password) {
            $result['message'] = 'password baru dan konfirmasi password tidak sama';
            return response()->json($result);
        }

        $user->password = Hash::make($request->new_password);
        $user->update();

        $result['message'] = 'Success update password';
        $result['status'] = true;
        $result['data'] = $user;
        return response()->json($result);
        // return redirect('/user/logout');

}
    // ini untuk change password
//     public function updatePassword(Request $request, $id){
//         $result = [
//             'status'=> false,
//             'data' => null,
//             'message'=> '',
//             'newToken' => csrf_token()
//         ];
//     $auth = Auth::user();
//     $user = User::where('id', $auth->id)->first();

//     // ini untuk mengecek apakah old paw dan pw user sudah sama
//     if(Hash::check($request->old_password, $user->password)){
//         $result['message'] = 'Old password wrong!';
//         return response()->json($result);
//     }
//     // untuk mengecek apakah old pw dan pw user tidak sama
//     if($request->new_password != $request->confirm_password){
//         $result['message'] = 'New password and confirm password not same';
//         return response()->json($result);
//     }
//     $user->password = Hash::make( $request->new_password );
//     $user->update();

//     $result['message'] = 'succes update password';
//     $result['status'] =  true;

//     return response()->json($result);
// }
    // setelah itu panggil di web.ph
}