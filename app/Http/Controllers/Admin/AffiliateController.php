<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{

    public function affiliateList(Request $request)
    {
        $allUsers = Affiliate::orderBy('id','asc')->get();
        return view('admin.affiliate.index', compact('allUsers'));
    }


    public function affiliateCreate(Request $request)
    {
        return view('admin.affiliate.create');
    }

    public function affiliateStore(Request $request)
    {   
        $request->validate([
            'affiliate_name'     => 'required|unique:affiliates,affiliate_name',
           
        ]); 
        $data['affiliate_name'] =  $request->affiliate_name; 
        $data['affiliate_links'] =  $request->affiliate_link; 
        if ($request->hasFile('affiliate_image')) {
            $file = $request->file('affiliate_image');
            $affiliate_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'admin-assets/uploads/affiliate/';
            $file->move(public_path($destinationPath), $affiliate_image);
            $data['image'] = $affiliate_image;
        }
        Affiliate::create($data);
        return redirect()->route('affiliate.list')->with('success', 'Affiliate  Create Successfully');
    }
    public function relationEdit(Request $request, $id)
    {
        $Category = Affiliate::find($id);
        return view('admin.affiliate_name.edit', compact('Category'));
    }

    public function affiliateUpdate(Request $request)
    {    
        $request->validate([
            'affiliate_name'   => 'required|unique:affiliates,affiliate_name,'.$request->affiliate_id,
            'status'          => 'required',
        ]);
        $data['affiliate_name'] = $request->affiliate_name;
        $data['affiliate_links'] =  $request->affiliate_link; 
        if ($request->hasFile('affiliate_image')) {
            $file = $request->file('affiliate_image');
            $affiliate_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'admin-assets/uploads/affiliate/';
            $file->move(public_path($destinationPath), $affiliate_image);
            $data['image'] = $affiliate_image;
        }
        $data['status'] =    $request->status; 
        Affiliate::where('id', $request->affiliate_id)->update($data);
        return redirect()->route('affiliate.list')->with('success', 'Affiliate Update Successfully');
    }


    public function affiliateDelete($id)
    {
        $data = Affiliate::find($id);
        $data->delete();
        return redirect()->route('affiliate.list')->with('success', 'Affiliate  Delete Successfully');
    }

}
