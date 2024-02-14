<?php

namespace App\Traits;



use Illuminate\Http\Request;

trait pictureTrait
{
    public function addPic(Request $request,$file_name,$disk,$folder=null){
        $image = time() . '_' . $request->file($file_name)->getClientOriginalName();
        if($folder==null){
            $path = $request->file($file_name)->storeAs($disk,$image);
        }
        else{
            $path = $request->file($file_name)->storeAs($disk,$image,$folder);
        }
        return $path;
    }
}
