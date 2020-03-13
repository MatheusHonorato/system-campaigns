<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Clinic;
use App\Campaign;
use Auth;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::orderBy('name', 'ASC')->paginate(15);
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();

        return view('clinics', compact('clinics','clinics_option','campaigns_option'));
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
                'name' => ['required', 'string', 'max:100'],
                'clinic_record' => ['required', 'string', 'max:100'],
                'technical_manager' => ['required', 'string', 'max:100'],
                'professional_record' => ['required', 'string', 'max:100']
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
    
                'clinic_record.required' => 'O campo Registro clínico é obrigatório.',
                'clinic_record.max' => 'Desculpe o Registro clínico excede o limite de caracteres.',
    
                'technical_manager.required' => 'O campo Responsável técnico é obrigatório.',
                'technical_manager.max' => 'Desculpe o campo Responsável técnico excede o limite de caracteres.',
    
                'professional_record.required' => 'O campo Registro profissional é obrigatório.',
                'professional_record.max' => 'Desculpe o campo Registro profissional excede o limite de caracteres.'
    
            ]);
    
            Clinic::create($request->all());
    
            return back()->with('success','Cadastro efetuado com sucesso!');
        } else {
            return back()->with('error','Usuário não autorizado.');
        }
       
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
        if(Auth::user()->type_user == 0) {
            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'clinic_record' => ['string', 'max:100'],
                'technical_manager' => ['string', 'max:100'],
                'professional_record' => ['string', 'max:100']
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
    
                'clinic_record.required' => 'O campo Registro clínico é obrigatório.',
                'clinic_record.min' => 'Desculpe, mas o campo Registro clínico deve possuir no mínimo 10 caracteres.',
                'clinic_record.max' => 'Desculpe o Registro clínico excede o limite de caracteres.',
    
                'technical_manager.required' => 'O campo Responsável técnico é obrigatório.',
                'technical_manager.min' => 'Desculpe, mas o campo Responsável técnico deve possuir no mínimo 10 caracteres.',
                'technical_manager.max' => 'Desculpe o campo Responsável técnico excede o limite de caracteres.',
    
                'professional_record.required' => 'O campo Registro profissional é obrigatório.',
                'professional_record.min' => 'Desculpe, mas o campo Registro profissional deve possuir no mínimo 10 caracteres.',
                'professional_record.max' => 'Desculpe o campo Registro profissional excede o limite de caracteres.'
            ]);
                
            if($request->clinic_record == null) {
                $request->clinic_record = "";
            }
            if($request->technical_manager == null) {
                $request->technical_manager = "";
            }
            if($request->professional_record == null) {
                $request->professional_record = "";
            }
            
            $clinic = Clinic::find($id); 
            $clinic->update($request->all());
    
            return back()->with('success','Post atualizado com sucesso!');
        } else {
            return back()->with('error','Usuário não autorizado.');
        }        
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
            $clinic = Clinic::find($id); 
            $clinic->delete();

            return redirect()->back()->with('success','Clínica excluída com sucesso!');
        } else {
            return back()->with('error','Usuário não autorizado.');
        }     
    }
}
