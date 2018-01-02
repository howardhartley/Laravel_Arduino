<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\MakeCategoryRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);
        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('errors.404');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MakeCategoryRequest $request)
    {

        Category::create(['name' => trim($request->name)]);
        Session::flash('complete', 'Η κατηγορία έχει δημιουργηθεί.');
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Category::findOrFail($id)->name == trim($request->name)){
            Session::flash('nothing', 'Δεν πραγματοποιήθηκε κάποια αλλαγή.');
            return redirect('admin/categories');
        }

        $this->validate($request, [
            'name' => 'required|unique:categories|max:255'
        ]);


        Category::findOrFail($id)->update(['name' => trim($request->name)]);
        Session::flash('update', 'Η κατηγορία έχει ανανεωθεί.');
        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        Session::flash('delete', 'Η κατηγορία έχει διαγραφεί.');
        return redirect()->back();

    }


    public function show($id)
    {
        return view('errors.404');
    }
}
