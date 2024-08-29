<?php

namespace App\Http\Controllers\site;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccueilController extends Controller
{
    //

    public function index(){
        try {
            $data_slide = Slide::with('media')->orderBy('id' , 'DESC')->get();
         
            return view('site.pages.index' , compact(
                'data_slide'
            ));
           
        } catch (\Throwable $e) {
           return $e->getMessage();
        }

    }
}
