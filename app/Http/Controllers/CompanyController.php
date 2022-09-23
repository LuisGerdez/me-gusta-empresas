<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['view']]);
    }

    public function add()
    {
        return view('add_company');
    }

    public function save(Request $request)
    {
        $company = new Company();
        $company->name = $request->company_name;
        $company->description = $request->company_description;
        if($request->company_url) {
            $company->image_url = $request->company_url;
        }
        $company->created_by = $request->creator;
        $company->save();

        return redirect()->route('view_company', $company->id);
    }

    public function view($id)
    {
        //return Company::find($id);
        return view('view_company', ['company' => Company::find($id)]);
    }
}
