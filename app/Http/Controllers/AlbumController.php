<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use ImagesManager\Album;
use ImagesManager\Photo;
use Auth;


// validator when creating a new album
use ImagesManager\Http\Requests\CreateAlbumRequest;
use ImagesManager\Http\Requests\EditAlbumRequest;
use ImagesManager\Http\Requests\DeleteAlbumRequest;

// get helper functions (to delete photos)
use ImagesManager\Http\Controllers\PhotoController;


class AlbumController extends Controller
{

    // make sure the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }





    // show all albums of this user
    public function getIndex()
    {
        $albums = Auth::user()->albums;
    	return view('albums/show', ['albums' => $albums]);    	
    }






    // CREATE methods
    public function getCreateAlbum()
    {
    	return view('albums/create-album');    	
    }
    public function postCreateAlbum(CreateAlbumRequest $request)
    {
        $user = Auth::user();

        // get the fields from the form
        $title       = $request->get('title');
        $description = $request->get('description');

        // create a new record in the Albums table
        Album::create(
            [
                'title'       => $title,
                'description' => $description,
                'user_id'     => $user->id,
            ]
        );

    	return redirect('validated/albums/')->with(['album_created' => 'The album has been created.']);    	
    }






    // EDIT methods
    // (id comes as a part of the url, not in a request!)
    public function getEditAlbum($id)
    {
        $album = Album::find($id);
        return view('albums/edit-album', ['album' => $album]);     
    }

    public function postEditAlbum(EditAlbumRequest $request)
    {
        $album = Album::find($request->get('id'));

        $album->title = $request->get('title');
        $album->description = $request->get('description');

        $album->save();

    	return redirect('validated/albums')->with(['edited' => 'The album has been edited']);
    }






    // DELETE method

    public function postDeleteAlbum(DeleteAlbumRequest $request)
    {
        // get album id from the HTTP POST request
        $id = $request->get('id');
        // get the album data object
        $album = Album::find($id);
        // get all photos in this album
        $photos = $album->photos;
        // we must make sure that there are no photos in this album any more!
        $photosCount = $photos->count();

        if ( $photosCount > 0 ) {
            if ($request->get('delPhotos')) {
                $controller = new PhotoController;
                foreach ($photos as $photo) {
                    $controller->deleteImage($photo->path);
                    $photo->delete();
                }
            } else {
                return redirect('validated/albums')->with( ['error' => "Can't delete, the album still has ".(string)$photosCount.' photo(s)!'] );
            }
        }

        $album->delete();
    	return redirect('validated/albums')->with(['deleted' => 'The album has been deleted']);
    }


}
