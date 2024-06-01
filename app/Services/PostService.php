<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;

class PostService {
    
    public function uploadMedias(StorePostRequest $request)
    {
    	if($request->hasFile('medias'))
		{
	    	$paths = [];
	    	$medias = $request->file('medias');
	    	foreach($medias as $media){
	    		$path = $media->store('media', 'public');
	    		$type = explode("/", $media->getMimeType())[0];
	    		array_push($paths, ['path' => $path, 'type' => $type]);
	    	}
    		return $paths;
	    }
	    return [];
    }
    
}