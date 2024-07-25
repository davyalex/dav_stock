<?php

namespace App\Http\Controllers\backend\media;

use App\Models\MediaContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MediaCategory;
use RealRashid\SweetAlert\Facades\Alert;

class MediaContentController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data_media_category = MediaCategory::get();
        $data_media_content = MediaContent::with(['media', 'media_category'])->get();
        // dd($data_media_content->toArray());
        $data_media_content->sortBy('name');
        return view('backend.pages.media.content.index', compact('data_media_content', 'data_media_category'));
    }


    public function create()
    {
        $data_media_category = MediaCategory::whereStatus('active')->OrderBy('position', 'ASC')->get();

        return view('backend.pages.media.content.create', compact('data_media_category'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //request validation ........
        $request->validate([
            'title' => 'required',
            'categorie' => 'required',
            'image' => '',
        ]);




        $data_media_content = MediaContent::firstOrCreate([
            'title' => $request['title'],
            'url' => $request['url'],
            'media_categories_id' => $request['categorie'],
            'status' => $request['status'],
        ]);

        if ($request->images) {

            foreach ($request->input('images') as $fileData) {
                // Decode base64 file
                $fileData = explode(',', $fileData);
                $fileExtension = explode('/', explode(';', $fileData[0])[0])[1];
                $decodedFile = base64_decode($fileData[1]);

                // Create a temporary file
                $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.' . $fileExtension;
                file_put_contents($tempFilePath, $decodedFile);

                // Add file to media library
                $data_media_content->addMedia($tempFilePath)->toMediaCollection('galleryMedia');

                // // Delete the temporary file
                // unlink($tempFilePath);
            }
        }


        return response([
            'message' => 'operation reussi'
        ]);
    }

    public function edit(string $id)
    {
        //
        $id = $id;
        $data_media_category = MediaCategory::whereStatus('active')->OrderBy('position', 'ASC')->get();
        $data_media_content = MediaContent::with('media')->whereId($id)->first();

        // dd( $data_blog_content->toArray());

        //get Image from database
        $galleryMedia = [];

        foreach ($data_media_content->getMedia('galleryMedia') as $value) {
            // Read the file content
            $fileContent = file_get_contents($value->getPath());

            // Encode the file content to base64
            $base64File = base64_encode($fileContent);
            array_push($galleryMedia, $base64File);
        }

        // dd($galleryBlog);

        return view('backend.pages.media.content.edit', compact('data_media_content', 'data_media_category', 'galleryMedia', 'id'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //request validation ......
        $request->validate([
            'title' => 'required',
            'categorie' => 'required',
            'image' => '',
        ]);

        $data_media_content = tap(MediaContent::find($id))->update([
            'title' => $request['title'],
            'url' => $request['url'],
            'media_categories_id' => $request['categorie'],
            'status' => $request['status'],
        ]);

        if ($request->images) {
            $data_media_content->clearMediaCollection('galleryMedia');

            foreach ($request->input('images') as $fileData) {
                // Decode base64 file
                $fileData = explode(',', $fileData);
                $fileExtension = explode('/', explode(';', $fileData[0])[0])[1];
                $decodedFile = base64_decode($fileData[1]);

                // Create a temporary file
                $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.' . $fileExtension;
                file_put_contents($tempFilePath, $decodedFile);

                // Add file to media library
                $data_media_content->addMedia($tempFilePath)->toMediaCollection('galleryMedia');

                // // Delete the temporary file
                // unlink($tempFilePath);
            }
        }


        return response([
            'message' => 'operation reussi'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        MediaContent::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
