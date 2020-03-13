<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Campaign;
use App\Clinic;
use App\Post;
use App\CampaignPost;
use Storage;
use Auth;
use App\Type;
use App\CategoryCampaign;
use App\User;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        $type_id = 0;
        if(count($types) > 0){
            $type_id = $types[0]->id;
        } 
        $campaigns = Campaign::orderBy('name', 'ASC')->paginate(15);
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();

        return view('campaigns', compact('type_id','campaigns','clinics_option','campaigns_option','types'));
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

            CategoryCampaign::create([
                'campaign_id' => $campaign->id,
                'category_id' => $request->category
            ]);

    
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
        $types = Type::all();
        $posts = Post::where('campaign_id', $id)->paginate(30);
        $campaigns = Campaign::all();
        $clinics_option = Clinic::orderBy('name', 'ASC')->get();
        $campaigns_option = Campaign::all();
        $campaign = Campaign::find($id);

        $user = User::find(1);
        $logo_one = $user->path_logo_one;
        $logo_two = $user->path_logo_two;

        return view('posts', compact('id','logo_one','logo_two','types','posts','campaign','campaigns','clinics_option','campaigns_option'));
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
            ],[
                'name.required' => 'O campo Nome é obrigatório.',
                'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
                'name.max' => 'Desculpe o nome excede o limite de caracteres.',
    
            ]);
    
            $campaign = Campaign::find($id); 
            $campaign->update([
                'name' => $request->name
            ]);
            $category_campaign = CategoryCampaign::where('campaign_id', $id)->first();
            if($category_campaign) {
                $category_campaign->update([
                    'category_id' => $request->category
                ]);
            } else {
                $category_campaign = CategoryCampaign::create([
                    'category_id' => $request->category,
                    'campaign_id' => $id
                ]);
            }
    
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
    
            $category_campaign = CategoryCampaign::where('campaign_id', $id)->first();
            $category_campaign->delete();
            $campaign = Campaign::find($id); 
            $campaign->delete();
    
            return redirect()->back()->with('success','Campanha excluída com sucesso!');
        } else {
            return redirect()->back()->with('error','Usuário não autorizado');
        }
       
    }
}
