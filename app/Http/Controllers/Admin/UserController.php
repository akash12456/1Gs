<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Admin;
use App\Models\Interest;
use App\Models\Promt;
use App\Models\ProfileDetail;
use App\Models\Relation;
use App\Models\Language;
use App\Models\Additional;
use App\Models\Sexual;
use App\Models\CreatorBrandProfile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Trait\ImageUpload;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    use ImageUpload;

    public function userList(Request $request)
    {
        $allUsers = Patient::orderBy('id','asc')->get();
        return view('admin.users.index', compact('allUsers'));
    }

    public function create_user(Request $request)
    {
        return view('admin.users.create' , ['user' => null]);
    }



    public function userStore(Request $request){

        // dd($request->all());
        $id = $request->user_id;

        $path = public_path() . '/user_images';

        $profilephoto = $request->hasFile('profilephoto')
        ? $this->image_upload($request->file('profilephoto'), $path, $request->olddocument2)
        : $request->oldprofilephoto;


        $user = $id ? Patient::findOrFail($id) : new Patient();
        $data = [
            'first_name'             => $request->first_name,
            'last_name'             => $request->first_name,
            'email'                  => $request->email,
            'status'                 => $request->status,
            'phone_number'           => $request->phone_number,
            'gender'                 => $request->gender,
            'dob'                 => $request->dob,
            'address'                 => $request->address,
            'nationality'                 => $request->nationality,
            'password'                 =>  Hash::make($request->password),
            'profilePhoto'             => $profilephoto,
        ];


        if ($id) {
            $user->update($data);
        } else {
            $user = Patient::create($data);
        }

        return redirect()->route('user.list')->with('success', $id ? 'User Updated Successfully' : 'User Created Successfully');
    }




    public function userEdit($id = null){
        if ($id) {
            $user = Patient::find($id);
            return view('admin.users.create',compact('user'));
        }
    }

    public function userDelete($id)
    {
        $data = Patient::find($id);
        $ImagePath = public_path('admin-assets/uploads/profileimages/') . $data->profile_image;
        File::delete($ImagePath);
        $data->delete();
        return redirect()->route('user.list')->with('success', 'User Delete Successfully');
    }







    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'image'        => 'image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        $admin_id = Auth::guard('admin')->user()->id;
        $user = Admin::where('id', $admin_id)->first();

        if ($request->hasFile('image')) {
            //deleting previous image
            $ImagePath = public_path('admin-assets/uploads/profileimages/') . $user->profile_image;
            File::delete($ImagePath);
            $user->delete();

            $file = $request->file('image');
            $admin_profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'admin-assets/uploads/profileimages/';
            $file->move(public_path($destinationPath), $admin_profile_image);
            $user->profile_image = $admin_profile_image;
        }
        $user->save();
        return back()->with('success', 'Profile image updated successfully');
    }
    public function emailExistsOrNote(Request $request)
    {
        $email = $request->input('email');
        $exists = Patient::where('email', $email)->exists();
        if(!$exists)
        {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }


    public function userStatusChange(Request $request)
    {
        $user = Patient::where('id',$request->user_id)->first();
        if($user)
        {
            $current_status = $user->status;
            $user->status = $current_status == "active" ? "inactive" : "active";
            $user->save();
            return response()->json(["status" => "success","message" => "status changes successfully","user_status" =>$user->status]);
        }
        return response()->json(["status" => "error","message" => "user not found"]);
    }

}
