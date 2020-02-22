<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Campaign;
use App\CampaignPost;
use App\Figure;
use App\PostImage;
use Storage;

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

        return view('posts', compact('posts','campaigns'));
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
            'images.*' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg|max:5000|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000']

        ],[
            'color.required' => 'O campo Cor é obrigatório.',

            'name.required' => 'O campo Nome é obrigatório.',
            'name.max' => 'Desculpe o nome excede o limite de caracteres.',
            
            'images.*.required' => 'O campo Imagem é obrigatório.',
            'images.*.mimes' => 'Somente arquivos de imagem são aceitos: jpeg, jpg, png, gif, svg.',
            'images.*.max' => 'Somente são aceitas images de até 5MB.'
        ]);
            
        $post = Post::create(
            ['name' => $request->name, 'color' => $request->color]
        );

        CampaignPost::create(
            ['campaign_id' => $request->campaign, 'post_id' => $post->id]
        );
    
        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile('images')) 
        {
            foreach($request->file('images') as $image)
            {
                if($image->isValid())
                {
                    $new_image = Figure::create(
                        ['path' => $image->store('images')]
                    );

                    PostImage::create(
                        ['post_id' => $post->id, 'figure_id' => $new_image->id]
                    );
                }
                unset($image);
            }
        }

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
        $post = Post::find($id);
        $campaigns = Campaign::all();

        $post_images = PostImage::where('post_id', $id)->get();

        $images_id = [];

        foreach($post_images as $post_image) {
            $images_id[] =  $post_image->figure_id;
        }

        $images = [];

        foreach($images_id as $image_id) {
            $images[] = Figure::find($image_id);
        }

        $campaign_post = CampaignPost::where('post_id', $id)->first();
        
        return view('editpost', compact('post','campaign_post','campaigns','images'));
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
            'name' => ['required', 'string', 'min:4', 'max:100'],
            'color' => ['required', 'string', 'min:4', 'max:100'],
        ],[
            'name.required' => 'O campo Nome é obrigatório.',
            'name.min' => 'Desculpe, mas o nome deve possuir no mínimo 10 caracteres.',
            'name.max' => 'Desculpe o nome excede o limite de caracteres.',

            'color.required' => 'O campo Cor é obrigatório.'
        ]);
        
        $post = Post::find($id);
        $post->update(
            ['name' => $request->name, 'color' => $request->color]
        );

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
