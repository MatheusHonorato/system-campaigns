<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Clinic;
use App\Campaign;
use Auth;
use App\Type;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->type_user == 0) {
            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'type' => ['required', 'string', 'max:100'],
                'date' => ['required', 'date']
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
            ]);

            if(
                Category::create([
                    'type_id' => $request->type, 
                    'name' => $request->name, 
                    'date' => $request->date
                ])
            ) {
                return back()->with('success','Categoria atualizada com sucesso!');
            }
        }  
        return back()->with('error','Você não possui permissão!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        $types = Type::all();
        $categories = Category::where('type_id', $type)->orderBy('name', 'ASC')->paginate(15);
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();

        return view('categories', compact('categories','clinics_option','campaigns_option','types'));
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

    public function list_filter($type)
    {
        return $categories = Category::where('type_id', $type)->orderBy('name', 'ASC')->get();
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
