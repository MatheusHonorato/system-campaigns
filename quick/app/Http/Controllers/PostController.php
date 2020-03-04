<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Campaign;
use App\CampaignPost;
use App\Figure;
use Storage;
use App\Clinic;
use Auth;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('campaign_id', $request->id)->paginate(30);
        $campaigns = Campaign::all();
        $clinics_option = Clinic::all();
        $campaigns_option = Campaign::all();
        $campaign = Campaign::find($request->id);

        $user = User::find(1);
        $logo_one = $user->path_logo_one;
        $logo_two = $user->path_logo_two;

        return view('posts', compact('logo_one','logo_two','posts','campaign','campaigns','clinics_option','campaigns_option'));
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
                'color' => ['required', 'string', 'max:100'],
                'campaign' => ['required', 'string', 'max:100'],
                'logo' => ['required', 'string', 'max:10'],
                'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg|max:5000|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000']
    
            ],[
                'color.required' => 'O campo Cor é obrigatório.',
                'campaign.required' => 'O campo Campanha é obrigatório.',
                'image.required' => 'O campo Imagem é obrigatório.',
                'image.mimes' => 'Somente arquivos de imagem são aceitos: jpeg, jpg, png, gif, svg.',
                'image.max' => 'Somente são aceitas images de até 5MB.'
            ]);
    
            // Verifica se informou o arquivo e se é válido
            if ($request->hasFile('image')) 
            {
               
                if($request->image->isValid())
                {
                    $post = Post::create(
                        ['color' => $request->color, 'logo' => $request->logo, 'campaign_id' => $request->campaign, 'image' => $request->image->store('images')]
                    );
                }
                    unset($image);
            }
    
            CampaignPost::create(
                ['campaign_id' => $request->campaign, 'post_id' => $post->id]
            );
        
    
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

    public function list_filter($id)
    {
        $posts = Post::where('campaign_id', $id)->get();

        return $posts;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
                'name' => ['string', 'max:100'],
                'color' => ['string', 'max:100'],
            ],[
                'name.max' => 'Desculpe o nome excede o limite de caracteres.'
            ]);
            
            $post = Post::find($id);
    
            // Verifica se informou o arquivo e se é válido
            if ($request->hasFile('image')) 
            {
               
                if($request->image->isValid())
                {
                    $post->update(
                        ['color' => $request->color, 'logo' => $request->logo, 'image' => $request->image->store('images')]
                    );
                }
                    unset($image);
            } else {
                
                $post->update(
                    ['color' => $request->color, 'logo' => $request->logo]
                );
            }
    
            $campaign_post = CampaignPost::where('post_id', $id)->first();
            $campaign_post->campaign_id = $request->campaign;
            $campaign_post->save();
    
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
            $campaign_post = CampaignPost::where('post_id',$id)->first();
            $campaign_post->delete();
            
            $post = Post::find($id);
    
            Storage::disk('public')->delete($post->image);
    
            $post->delete();
    
            return redirect()->back()->with('success','Post excluído com sucesso!');
        } else {
            return back()->with('error','Usuário não autorizado.');
        }
    }
}
