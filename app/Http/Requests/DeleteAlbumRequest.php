<?php

namespace ImagesManager\Http\Requests;

use ImagesManager\Http\Requests\Request;


use ImagesManager\Album;
use Auth;


class DeleteAlbumRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // make sure we only show photos of albums that belongs to the current user
        $user  = Auth::user();
        $id    = $this->get('id');
        $album = $user->albums()->find($id);
        if ($album){
            return true;
        }
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
            // the Validation rule "exists:albums,id" means:
            //      make sure this id exists in the column 'id' of the table 'albums'
            'id'          => 'required|exists:albums,id',
        ];
    }
}
