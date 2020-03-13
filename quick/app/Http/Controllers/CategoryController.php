<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Clinic;
use App\Campaign;
use Auth;
use App\Type;
use App\CategoryCampaign;

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
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
            ]);

            if(
                Category::create([
                    'type_id' => $request->type, 
                    'name' => $request->name
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
    public function show($id)
    {
        $types = Type::all();
        $type_id = 0;
        if(count($types) > 0){
            $type_id = $types[0]->id;
        } 
        
        $categorie_campaign = CategoryCampaign::where('category_id', $id)->get();
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();

        if(count($categorie_campaign) != 0) {
            foreach($categorie_campaign as $cc) {
                $ids[] = $cc->campaign_id;
            }
            
            $campaigns = Campaign::whereIn('id', $ids)->orderBy('name', 'ASC')->paginate(15);

            return view('campaigns', compact('type_id','campaigns','clinics_option','campaigns_option','types'));

        }
        
        return view('campaigns', compact('type_id','clinics_option','campaigns_option','types'));
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
        $categorie_campaign = CategoryCampaign::where('category_id', $id)->get();
        if(count($categorie_campaign)>0) {
            return redirect()->back()->with('error','Uma categoria não pode ser excluida se ainda existirem campanhas associadas a ela!');
        } else {
            $category = Category::find($id);
            $category->delete();
            return redirect()->back()->with('success','Categoria excluída com sucesso!');
        }
    }
}
