<?php

namespace ImagesManager\Http\Requests;

use ImagesManager\Http\Requests\Request;

use Auth;
use ImagesManager\Photo;


class EditPhotoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // get photo id from the request
        $id = $this->get('id');
        // get the photo DB object
        $photo = Photo::find($id);
        // find if this photo belongs to an album that belongs to this authenticated user
        $album = Auth::user()->albums()->find($photo->album_id);
        // if yes, return true (access is allowed)
        if ($album) {
            return true;
        }
        // album was not from this user, so access is forbidden!
        return false;
    }


    // we implement our own 'forbidden' method to show a more userfriendly result
    public function forbiddenResponse()
    {
        return $this->redirector->to('/');
    }    


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // validation for photo data updates
            'id'          => 'required|exists:photos,id',
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'image|max:20000',
        ];
    }
}
