<?php

namespace App\Http\Controllers;

use App\Http\Requests\EthnicityRequest;
use App\Models\Ethnicity;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EthnicityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::check())
        {
            if (Auth::user()->hasRole('admin'))
            {
                $data = Ethnicity::all();
                return view('ethnicity.index', ['ethnicities' => $data]);
            }
            else
            {
                return abort(404);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (Auth::check())
        {
            if (Auth::user()->hasRole('admin'))
            {
                return view('ethnicity.create');
            }
            else
            {
                return abort(404);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EthnicityRequest $request)
    {
        Ethnicity::firstOrCreate(['ethnicity' => $request->input('ethnicity')]);
        return redirect(route('ethnicity.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Ethnicity $ethnicity)
    {
        $ethnicity->delete();
        return redirect(route('dashboard'));
    }
}
