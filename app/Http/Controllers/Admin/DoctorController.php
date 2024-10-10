<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ImageUpload;
use App\Models\Doctor;

class DoctorController extends Controller
{
    //

        use ImageUpload;


    public function doctorList(){
        $allDoctors = Doctor::orderBy('id','asc')->get();
        return view('admin.doctor.index',compact('allDoctors'));
    }

    public function create_doctor(Request $request)
    {
        return view('admin.doctor.create');
    }
    public function doctorStore(Request $request)
    {
        $id = $request->driver_id;
        $path = public_path() . '/doctor_images';

        // Validate Request Data
        // $request->validate([
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:doctors,email,' . $id,
        //     'phone_number' => 'required|numeric',
        //     'document1' => 'nullable|file|mimes:jpeg,png,pdf',
        //     'document2' => 'nullable|file|mimes:jpeg,png,pdf',
        //     'profilephoto' => 'nullable|image|mimes:jpeg,png|max:2048',
        // ]);

        // dd($request->all());
        // Handle Document Uploads
        $document2 = $request->hasFile('document2')
            ? $this->image_upload($request->file('document2'), $path, $request->olddocument2)
            : $request->olddocument2;

        $document1 = $request->hasFile('document1')
            ? $this->image_upload($request->file('document1'), $path, $request->olddocument1)
            : $request->olddocument1;

        $profilephoto = $request->hasFile('profilephoto')
            ? $this->image_upload($request->file('profilephoto'), $path, $request->oldprofilephoto)
            : $request->oldprofilephoto;

        // Prepare Data


        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'status' => $request->status,
            'verifyStatus' => $request->verify,
            'abaility' => $request->abaility,
            'specialty' => $request->specialty,
            'address' => trim($request->address),
            'specialization' => $request->specialization,
            'profilephoto' => $profilephoto,
            'document1' => $document1,
            'document2' => $document2,
        ];

        // Create or Update Doctor
        $doctor = $id ? Doctor::findOrFail($id) : new Doctor();
        $id ? $doctor->update($data) : Doctor::create($data);

        return redirect()->route('doctor.list')->with('success', $id ? 'Doctor Updated Successfully' : 'Doctor Created Successfully');
    }


    public function doctorEdit($id = null){
        if ($id) {
            $driver = Doctor::find($id);
            return view('admin.doctor.create',compact('driver'));
        }
    }
    public function doctorDelete($id){
        if ($id) {
            $doctor = Doctor::find($id);
            $doctor->delete();
            return redirect()->route('doctor.list')->with('success', $id ? 'Doctor deleted Successfully' : 'Doctor deleted Successfully');
    }
    }

    public function doctorView($id){
        $doctor = Doctor::find( $id );
        return view('admin.doctor.view',compact('doctor'));
    }

}
