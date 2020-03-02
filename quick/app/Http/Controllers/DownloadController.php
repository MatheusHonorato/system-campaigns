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
use App\Campaign;

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
        //array_map('unlink', glob('storage/*.zip'));

        $campaign_posts = CampaignPost::where('campaign_id', $request->campaign)->get();
        $clinic = Clinic::find($request->clinic);
        
        if(count($campaign_posts) > 0) {

            $user = User::find(1);
            
            $count = 1;

            foreach($campaign_posts as $cp) {
    
                $post = Post::find($cp->post_id);

                // open an image file
                $img = Image::make('storage/'.$post->image);

                //width
                $width = Image::make('storage/'.$post->image)->width();
                //height
                $height = Image::make('storage/'.$post->image)->height();

                if($post->logo == 0) {
                    // and insert a watermark for example
                    $watermark = Image::make('storage/'.$user->path_logo_one);
                } else {
                    $watermark = Image::make('storage/'.$user->path_logo_two);
                    // and insert a watermark for example
                }
                
                $watermark->resize(256, null, function ($constraint) {
                    $constraint->aspectRatio();
                });                

                $img->insert($watermark, 'bottom-right', 30, 55);


                $name_img = $count.'.jpg';

                $color = $post->color;

                $clinic_name_format = mb_strtoupper($clinic->name, 'UTF-8');

                $text_rt = $clinic_name_format."\n"."RC: ".$clinic->clinic_record."\n"."RT: ".$clinic->technical_manager."\n"."CRO: ".$clinic->professional_record;

                ini_set('default_charset', 'UTF-8');

                $img->text($text_rt, 30/* x */, $height-30 /* y */, function($font) use ($color) {
                    $font->file(public_path('storage/fonts/calibri-bold.ttf'));
                    $font->size(14);
                    $font->color($color);
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });


                if($post->logo == 0) {
                    $color = '#7FC15E';
                } else {
                    $color = '#FFFFFF';
                }

                $img->text($clinic->name, $width-107/* x */, $height-30 /* y */, function($font) use ($color) {
                    $font->file(public_path('storage/fonts/calibri-bold-italic.ttf'));
                    $font->size(25);
                    $font->color($color);
                    $font->align('right');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $img->save('storage/images/tmp/'.$name_img);

                $count++;
            }

    
            $files = glob('storage/images/tmp/*');

            function clean($string) {
                $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
             
                $string = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) ); 

                $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
                
                return strtolower($string); // Removes special chars.
             }             

            $campaign = Campaign::find($request->campaign);
            $name_zip = clean($campaign->name."-".$clinic_name_format);
            
            Madzipper::make('storage/'.$name_zip.'.zip')->add($files)->close();
    
            return response()->download('storage/'.$name_zip.'.zip')->deleteFileAfterSend(true);


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
