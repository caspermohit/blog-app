<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class FileUploadController extends Controller
{
    public function create (){
        return view(Uplaod);
    }

    public function  store(Request $request){
        $request ->validate([
                    'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',

        ]);
        $file = $request->file('file');
        $fileName = time().$file->getClientOriginalName();
        $file->storeAs('ulploads', $fileName, 'public');
        return redirect()->back()->with('status', 'file uploaded successfully');
    }
}
