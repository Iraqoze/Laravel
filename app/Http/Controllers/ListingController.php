<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show all Listing
    public function index(){


        return view('listings.index', [
            'heading'=>'Latest Listings',
            'listings'=>Listing::latest()->filter(request(['tag', 'search']))->paginate(2)
        ]);
    }

    //Single Listing
    public function show(Listing $listing){

        return view('listings.show',[
            'listing'=>$listing
        ]);
    }


    //showing create form
    public function create(){

        return view('listings.create');
    }

    //storing a single listing
    public function store(Request $request){
        $formFields= $request->validate([
        'title'=>'required',
        'company'=>['required', Rule::unique('listings','company')],
        'location'=>'required',
        'website'=>'required',
        'email'=>['required','email'],
        'tags'=>'required',
        'description'=>'required'
        ]);


     if($request->hasFile('logo')){
      $formFields['logo']=$request->file('logo')->store('logos','public');
     }

     $formFields['user_id']=auth()->id();

     //dd($formFields);

        Listing::create($formFields);
        return redirect('/')->with('message','Listing Created Successfully');
    }

    //shwowng edit form
    public function edit(Listing $listing){
        return view('listings.edit',['listing'=>$listing]);
    }
    //update a single listing
    public function update(Request $request, Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields= $request->validate([
        'title'=>'required',
        'company'=>['required'],
        'location'=>'required',
        'website'=>'required',
        'email'=>['required','email'],
        'tags'=>'required',
        'description'=>'required'
        ]);


     if($request->hasFile('logo')){
      $formFields['logo']=$request->file('logo')->store('logos','public');
     }



        $listing->update($formFields);
        return back()->with('message','Listing updated Successfully');
    }

    //Deleting a listing
    public function destroy(Listing $listing){
        $listing->delete();
        return redirect('/')->with('message','Listing Deleted Successfully');
    }

    //Manage Listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }



}
