<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Storage;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('logo_one')) 
        {
           
            if($request->file('logo_one')->isValid())
            {
                $user = User::find(Auth::user()->id);
                if($user->path_logo_one != '') {
                    Storage::disk('public')->delete($user->path_logo_one);
                }
                $user->path_logo_one = $request->file('logo_one')->store('images/logos');
                $user->save();
            }
            
        }

        if ($request->hasFile('logo_two')) 
        {
           
            if($request->file('logo_two')->isValid())
            {
                $user = User::find(Auth::user()->id);
                if($user->path_logo_two != '') {
                    Storage::disk('public')->delete($user->path_logo_two);
                }
                $user->path_logo_two = $request->file('logo_two')->store('images/logos');
                $user->save();
            }
            
        }
        return back()->with('success','Logo atualizada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
