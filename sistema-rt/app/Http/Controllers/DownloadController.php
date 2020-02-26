<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Figure;
use App\User;
use Response;
use Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $figure = Figure::first();

        // open an image file
        $img = Image::make('storage/'.$figure->path);

        $user = User::where('email', 'adm@adm.com')->first();

        // and insert a watermark for example
        $img->insert('storage/'.$user->path_logo_one);

        //////////

        // open an image file
        $img_d = Image::make('storage/'.$figure->path);

        $user = User::where('email', 'adm@adm.com')->first();

        // and insert a watermark for example
        $img_d->insert('storage/'.$user->path_logo_two);
        // finally we save the image as a new file
        $img->save('storage/images/tmp/'.rand().'.jpg');

        $img_d->save('storage/images/tmp/'.rand().'.jpg');

        $files = Storage::disk('public')->allFiles('images/tmp');

        Zipper::make(public_path('images/tmp/test.zip'))->add($files);

        return response()->download(public_path('test.zip'));

        //return response()->download('storage/images/tmp/')->deleteFileAfterSend();
    
        //return $img->response(); //this code not right
        //return response()->download('storage/images/'.$img);

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
