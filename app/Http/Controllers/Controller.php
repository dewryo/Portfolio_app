<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showhome()
    {
        $images = Image::all();
        return view('index',['images' => $images]);
    }
}
