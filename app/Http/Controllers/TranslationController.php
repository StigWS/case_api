<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    public function updateTranslation(Request $request, Translation $translation)
    {
        $validator = Validator::make($request->all(), [
            'language_code' => 'sometimes|required|min:2',
            "entity_type" => 'sometimes|required',
            "entity_id" => "sometimes|required",
            'content_type' => 'sometimes|required',
            'content' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return $response['response'] = $validator->messages();
        }

        $translation->language_code = $request->language_code ?: $translation->language_code;
        $translation->entity_type = $request->entity_type ?: $translation->entity_type;
        $translation->entity_id = $request->entity_id ?: $translation->entity_id;
        $translation->content_type =  $request->content_type ?: $translation->content_type;
        $translation->content =  $request->content ?: $translation->content;

        $translation->save();

        return ['data' => 'Translation is updated!'];
    }
}
