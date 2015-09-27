<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use ImagesManager\Http\Requests\ShowPhotosRequest;
use ImagesManager\Http\Requests\CreatePhotoRequest;
use ImagesManager\Http\Requests\EditPhotoRequest;
use ImagesManager\Http\Requests\DeletePhotoRequest;

use ImagesManager\Album;
use ImagesManager\Photo;
use Auth;

use Carbon\Carbon;


class PhotoController extends Controller
{


    // make sure the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }




    // show   ALL   albums of this user
    public function getIndex(ShowPhotosRequest $request)
    {
        $album_id = $request->get('id');
        $album    = Album::find( $album_id );
        $photos = Album::find( $album_id )->photos;

    	return view( 'photos/show', ['photos' => $photos, 'id' => $album_id, 'title' => $album->title ] );    	
    }






    //         CREATE      methods (GET and POST)

    // 1. Show form
    public function getCreatePhoto(Request $request)
    {
        // get album id
        $id = $request->get('id');
    	return view( 'photos.create-photo', ['id' => $id] );    	
    }

    // 2. Process form data
    public function postCreatePhoto(CreatePhotoRequest $request)
    {
        $id    = $request->get('id');
        $image = $request->file('image');
        Photo::create([
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'path'        => $this->createImage($image),
            'album_id'    => $id,
        ]);
    	return redirect("validated/photos?id=$id")->with( [ 'photo_created' => 'The photo has been stored' ] );    	
    }





    /*
     *      EDIT       methods  (GET and POST)
     */
    // GET - provide data for editing form
    public function getEditPhoto($id)
    {
        $photo = Photo::find($id);
        return view( 'photos.edit-photo', ['photo' => $photo] );        
    }

    // POST - process updated photo data
    public function postEditPhoto(EditPhotoRequest $request)
    {
        // get the current photo using the
        // photo id from the hidden form field
        $photo = Photo::find( $request->get('id') );

        // check if the user provided a NEW image
        if ( $request->hasFile('image') ) {
            // first we need to delete the old image
            $this->deleteImage($photo->path);
            // now we can update the current photo DB object
            $photo->path = $this->createImage($request->file('image'));
        }
        // write the new data back to the DB
        $photo->title       = $request->get('title');
        $photo->description = $request->get('description');
        $photo->save();

        return redirect("validated/photos?id=$photo->album_id")->with( [ 'edited' => 'The photo has been updated' ] );     
    }




    //            DELETE     method  (POST only)

    public function postDeletePhoto(DeletePhotoRequest $request)
    {
        // get the current photo using the
        // photo id from the hidden form field
        $photo = Photo::find( $request->get('id') );

        // first we need to delete the old image
        $this->deleteImage($photo->path);

        // now delete the photo in the DB
        $photo->delete();

        return redirect("validated/photos?id=$photo->album_id")->with( [ 'deleted' => 'The photo has been deleted' ] );     
    }




    // HELPER FUNCTIONS


    /*
     * Delete an image
     */
    public function deleteImage($image)
    {
        // get current relative path
        $relPath  = getcwd().$image;
        $realPath = realpath($relPath);
        // delete file using real path
        if (file_exists($realPath))
        {
            unlink( $realPath );
        } 
    }




    /*
     * Function to handle file uploads
     */
    public function createImage($image)
    {
        $path = '/img/';
        // create a random name using the sha1 function
        $name = sha1(Carbon::now()).'.'.$image->guessExtension();
        $image->move(getcwd().$path, $name);
        return $path.$name;
    }


}

