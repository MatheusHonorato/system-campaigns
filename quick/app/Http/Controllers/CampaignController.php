<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Campaign;
use App\Clinic;
use App\Post;
use App\CampaignPost;
use Storage;
use Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::orderBy('name', 'ASC')->paginate(15);
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
                'images.*' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg|max:5000|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000'], 
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
    
                'images.*.required' => 'O campo Imagem é obrigatório.',
                'images.*.mimes' => 'Somente arquivos de imagem são aceitos: jpeg, jpg, png, gif, svg.',
                'images.*.max' => 'Somente são aceitas images de até 5MB.',
            ]);
    
            $campaign = Campaign::create(['name' => $request->name]);
                
            // Verifica se informou o arquivo e se é válido
             if ($request->hasFile('images')) 
            {
                foreach($request->file('images') as $image)
                {
                    if($image->isValid())
                    {
                        $post = Post::create(
                            ['color' => $request->color, 'logo' => $request->logo, 'campaign_id' => $campaign->id, 'image' => $image->store('images')]
                        );
    
                        CampaignPost::create(
                            ['campaign_id' => $campaign->id, 'post_id' => $post->id]
                        );
    
                        unset($image);
                    }
                } 
            }
    
            return back()->with('success','Campanha cadastrada com sucesso!');
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
        } else {
            return back()->with('error','Usuário não autorizado');
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
            $cp = CampaignPost::where('campaign_id', $id)->get();

            $posts = $cp;
            CampaignPost::where('campaign_id', $id)->delete();
    
            foreach($posts as $p) {
                $post = Post::find($p->id);
                Storage::disk('public')->delete($post->image);
                $post->delete();
            }
    
    
            $campaign = Campaign::find($id); 
            $campaign->delete();
    
            return redirect()->back()->with('success','Campanha excluída com sucesso!');
        } else {
            return back()->with('error','Usuário não autorizado');
        }
       
    }
}
