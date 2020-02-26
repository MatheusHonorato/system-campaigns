<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Campaign;
use App\Clinic;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::paginate(15);
        $clinics_option = Clinic::all();
        $campaigns_option = Campaign::all();

        return view('campaigns', compact('campaigns','clinics_option','campaigns_option'));
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
        $request->validate([
            'name' => ['required', 'string', 'min:10', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:100']
        ],[
            'name.required' => 'O campo Nome é obrigatório.',
            'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
            'name.max' => 'Desculpe o nome excede o limite de caracteres.',

            'description.required' => 'O campo Descrição é obrigatório.',
            'description.min' => 'Desculpe, mas a descrição deve possuir no mínimo 10 caracteres.',
            'description.max' => 'Desculpe a descrição excede o limite de caracteres.'
        ]);

        Campaign::create($request->all());

        return back()->with('success','Cadastro efetuado com sucesso!');
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
        
        $request->validate([
            'name' => ['required', 'string', 'min:10', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:100']
        ],[
            'name.required' => 'O campo Nome é obrigatório.',
            'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
            'name.max' => 'Desculpe o nome excede o limite de caracteres.',

            'description.required' => 'O campo Descrição é obrigatório.',
            'description.min' => 'Desculpe, mas a descrição deve possuir no mínimo 10 caracteres.',
            'description.max' => 'Desculpe a descrição excede o limite de caracteres.'
        ]);

        $campaign = Campaign::find($id); 
        $campaign->update($request->all());

        return back()->with('success','Campanha atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::find($id); 
        $campaign->delete();

        return redirect()->back()->with('success','Campanha excluída com sucesso!');
    }
}
