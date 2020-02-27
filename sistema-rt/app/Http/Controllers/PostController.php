<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Campaign;
use App\CampaignPost;
use App\Figure;
use App\PostImage;
use Storage;
use App\Clinic;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(15);
        $campaigns = Campaign::all();
        $clinics_option = Clinic::all();
        $campaigns_option = Campaign::all();
        $campaign_post = CampaignPost::all();

        return view('posts', compact('posts','campaigns','clinics_option','campaigns_option','campaign_post'));
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
            'name' => ['required', 'string'],
            'color' => ['required', 'string', 'max:100'],
            'logo' => ['required', 'string', 'max:10'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg|max:5000|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000']

        ],[
            'color.required' => 'O campo Cor é obrigatório.',

            'name.required' => 'O campo Nome é obrigatório.',
            'name.max' => 'Desculpe o nome excede o limite de caracteres.',
            
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
                    ['name' => $request->name, 'color' => $request->color, 'logo' => $request->logo, 'image' => $request->image->store('images')]
                );
            }
                unset($image);
        }

        CampaignPost::create(
            ['campaign_id' => $request->campaign, 'post_id' => $post->id]
        );
    

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $campaign_post = CampaignPost::where('post_id',$id)->first();
        $campaign_post->delete();
        
        $post_figures = PostImage::where('post_id', $id)->get();

        PostImage::where('post_id', $id)->delete();

        foreach($post_figures as $pf) {
            $figure = Figure::find($pf->figure_id);
            Storage::disk('public')->delete($figure->path);
            $figure->delete();
        }

        $post = Post::find($id);
        $post->delete();

        return redirect()->back()->with('success','Post excluído com sucesso!');
    }
}
