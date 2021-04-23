<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function getPage($page_id, $language_code = null)
    {
        if ($language_code)
        {
            return Page::where('id', $page_id)
                ->with(['translations' => function($q) use($language_code) {
                        $q->where('language_code', $language_code);
                    }])
                ->first();
        }

        return Page::where('id', $page_id)->with('translations')->first();
    }

    public function addPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'translations' => 'required|array',
            'translations.*.language_code' => 'required|min:2',
            'translations.*.content_type' => 'required',
            'translations.*.content' => 'required_if:translations.*.content_type,title',
            'parent_id' => 'sometimes|integer|nullable'
        ]);

        if ($validator->fails()) {
            return $response['response'] = $validator->messages();
        }

        $page = new Page;
        $page->parent_id = $request->parent_id;
        $page->save();

        foreach ($request->translations as $translation) {
            $page->translations()->forceCreate(
            [
                "language_code" => $translation['language_code'],
                "entity_type" => "page",
                "entity_id" => $page->id,
                "content_type" => $translation['content_type'],
                "content" => $translation['content'],
            ]);
        }

        return ['data' => 'Page is added!'];
    }
}
