<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Figure;
use App\User;
use Response;
use Storage;
use Madzipper;
use App\CampaignPost;
use App\Post;
use App\Color;
use App\Clinic;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        array_map('unlink', glob('storage/images/tmp/*.jpg'));
        array_map('unlink', glob('storage/*.zip'));

        $campaign_posts = CampaignPost::where('campaign_id', $request->campaign)->get();
        $clinic = Clinic::find($request->clinic);
        
        if(count($campaign_posts) > 0) {

            $user = User::find(1);

            foreach($campaign_posts as $cp) {
    
                $post = Post::find($cp->post_id);

                // open an image file
                $img = Image::make('storage/'.$post->image);
    
                if($post->logo == 0) {
                    // and insert a watermark for example
                    $img->insert('storage/'.$user->path_logo_one);
                } else {
                     // and insert a watermark for example
                     $img->insert('storage/'.$user->path_logo_two);
                }
                
                $name_img = rand().'.jpg';

                $color = $post->color;

                $text_rt = $clinic->name." ".$clinic->clinic_record." ".$clinic->technical_manager." ".$clinic->professional_record;

                $text_rt = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $text_rt ) ); 

                $img->text($text_rt, 10/* x */, 885 /* y */, function($font) use ($color) {
                    //$font->file('arial');
                    $font->size(35);
                    $font->color($color);
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(45);
                });

                $img->save('storage/images/tmp/'.$name_img);

            }
    
            $files = glob('storage/images/tmp/*');
            
            Madzipper::make('storage/test.zip')->add($files)->close();
    
            return response()->download('storage/test.zip');


        } else {
            return back()->with('error','A campanha não possui nenhum post associado.');
        }

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
        //
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
        //
    }
}
