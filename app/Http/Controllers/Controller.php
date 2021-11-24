<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{

    public function store (Request $request) {
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {

                $validated = $request->validate([
                    'image' => 'mimes:png|max:20000014',
                ]);

                $image = base64_encode(file_get_contents($request->file('image')));

                    $response = Http::asForm()->post('https://test.rxflodev.com', [
                        'imageData' => $image,
                    ]);
                    $message = json_decode($response->getBody()->getContents());
                    Session::put('image', $message->url);
                    Session::flash('success', "Success!");
                    return \Redirect::back();
            }
        }
    }


}
