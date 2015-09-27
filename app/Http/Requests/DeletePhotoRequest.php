<?php

namespace ImagesManager\Http\Requests;

use ImagesManager\Http\Requests\Request;


use Auth;
use ImagesManager\Photo;


class DeletePhotoRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'id'          => 'required|exists:photos,id',
        ];
    }
}
