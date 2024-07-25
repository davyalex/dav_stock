<?php

namespace App\Http\Controllers\backend\blog;

use App\Models\BlogContent;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class BlogContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_blog_content = BlogContent::with(['blog_category', 'media'])->get();
        // dd( $data_blog_content->toArray());

        return view('backend.pages.blog.content.index', compact('data_blog_content'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data_blog_category = BlogCategory::whereStatus('active')->OrderBy('position', 'ASC')->get();
        return view('backend.pages.blog.content.create', compact('data_blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //request validation ........
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'resume' => 'required',
            'category' => 'required',
            'image' => 'required',
        ]);


        // dd($request->all());

        $data_blog_content = BlogContent::create([
            'title' => $request['title'],
            'resume' => $request['resume'],
            'description' => $request['description'],
            'status' => $request['status'],
            'blog_categories_id' => $request['category'],

        ]);

        if (request()->hasFile('image')) {
            $data_blog_content->addMediaFromRequest('image')->toMediaCollection('blogImage');
        }


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
                $data_blog_content->addMedia($tempFilePath)->toMediaCollection('galleryBlog');

                // // Delete the temporary file
                // unlink($tempFilePath);
            }
        }
        // Alert::Success('Opération', 'SuccessMessage');
        // return back();

        return response([
            'message' => 'operation reussi'
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $id = $id;
        $data_blog_category = BlogCategory::whereStatus('active')->OrderBy('position', 'ASC')->get();
        $data_blog_content = BlogContent::with('media')->whereId($id)->first();

        // dd( $data_blog_content->toArray());

        //get Image from database
        $galleryBlog = [];

        foreach ($data_blog_content->getMedia('galleryBlog') as $value) {
            // Read the file content
            $fileContent = file_get_contents($value->getPath());

            // Encode the file content to base64
            $base64File = base64_encode($fileContent);
            array_push($galleryBlog, $base64File);
        }

        // dd($galleryBlog);

        return view('backend.pages.blog.content.edit', compact('data_blog_content', 'data_blog_category', 'galleryBlog', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //request validation ........
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'resume' => 'required',
            'category' => 'required',
            'image' => '',
        ]);


        $data_blog_content = tap(BlogContent::find($id))->update([
            'title' => $request['title'],
            'resume' => $request['resume'],
            'description' => $request['description'],
            'status' => $request['status'],
            'blog_categories_id' => $request['category'],
        ]);

        //image à la une
        if (request()->hasFile('image')) {
            $data_blog_content->clearMediaCollection('blogImage');
            $data_blog_content->addMediaFromRequest('image')->toMediaCollection('blogImage');
        }

        if ($request->images) {
            $data_blog_content->clearMediaCollection('galleryBlog');

            foreach ($request->input('images') as $fileData) {
                // Decode base64 file
                $fileData = explode(',', $fileData);
                $fileExtension = explode('/', explode(';', $fileData[0])[0])[1];
                $decodedFile = base64_decode($fileData[1]);

                // Create a temporary file
                $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.' . $fileExtension;
                file_put_contents($tempFilePath, $decodedFile);

                // Add file to media library
                $data_blog_content->addMedia($tempFilePath)->toMediaCollection('galleryBlog');

                // // Delete the temporary file
                // unlink($tempFilePath);
            }
        }


        return response([
            'message' => 'operation reussi'
        ]);

        // Alert::success('Opération réussi', 'Success Message');
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
        BlogContent::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
