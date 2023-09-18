<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\StoreUrl;
use Illuminate\Support\Facades\Log;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.add-url');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $urls=preg_split('/\r\n|\r|\n/', $request->input('urls'));
        $validator = Validator::make(['urls'=>$urls], [
            'urls' => 'required',
            'urls.*' => 'url',
        ]);
        if($validator->fails()) {
            throw new \ErrorException($validator->errors()->first());
        }
        foreach($urls as $url) {
            StoreUrl::dispatch($url);
        }

        Log::info(json_encode($urls));
        return response()->json(['success'=> true], 200);
    }

    public function list(Request $request){
        $per_page = $request->query('per_page');
        $search = $request->query('search');
        $sort_by = $request->query('sort_by');
        $sort_by_direction = $request->query('sort_by_direction');
        return response()->json(['urls'=>Url::where('url', 'like', '%'.$search.'%')->with('domain')->orderBy($sort_by, $sort_by_direction)->paginate($per_page)]);
    }
}
