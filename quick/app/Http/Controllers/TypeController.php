<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Type;
use App\Category;
use App\Clinic;
use App\Campaign;
use Auth;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::orderBy('name', 'ASC')->paginate(15);
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();

        return view('types', compact('types','clinics_option','campaigns_option'));
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
        if(Auth::user()->type_user == 0) {
            $request->validate([
                'name' => ['required', 'string', 'max:100']
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
            ]);

            if(
                Type::create(['name' => $request->name])
            ) {
                return back()->with('success','Tipo atualizado com sucesso!');
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
        $type_id = 0;
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();
        $categories = Category::where('type_id', $type)->paginate(15);
        return view('categories', compact('type_id','categories','clinics_option','campaigns_option','types'));
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
        if(Auth::user()->type_user == 0) {
            $categories = Category::where('type_id', $id)->get();
            if(count($categories) > 0) {
                return back()->with('error','Um tipo não pode ser excluído se ainda possuir categorias associadas a ele!');
            } 
            
            $type = Type::find($id);
            $type->delete();
            return back()->with('success','Tipo excluído com sucesso!');
        }

        return back()->with('error','Você não possui permissão!');
    }
}
