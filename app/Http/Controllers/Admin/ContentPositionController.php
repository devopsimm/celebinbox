<?php

namespace App\Http\Controllers\Admin;

use App\Events\PostUpdateEvent;
use App\Models\ContentPosition;
use App\Models\ContentPositionDetail;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Support\Facades\Cache;

/**
 * Class ContentPositionController
 * @package App\Http\Controllers
 */
class ContentPositionController extends Controller
{
    public $gService;

    public function __construct()
    {
        $this->gService = new GeneralService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $contentPositions = ContentPosition::paginate();

        return view('content-position.index', compact('contentPositions'))
            ->with('i', (request()->input('page', 1) - 1) * $contentPositions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $contentPosition = new ContentPosition();
        return view('content-position.create', compact('contentPosition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        request()->validate(ContentPosition::$rules);

        $contentPosition = ContentPosition::create($request->all());
        $id = $contentPosition->id;

        for ($i = 1; $i <= $contentPosition->slots;$i++){
            ContentPositionDetail::create([
                'content_position_id' => $id,
                'sequence' => $i,
                'type'=>$request->content_type
            ]);
        }
        Cache::forget('sidebar');
        return redirect()->route('content-positions.index')
            ->with('success', 'ContentPosition created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $contentPosition = ContentPosition::find($id);

        return view('content-position.show', compact('contentPosition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $contentPosition = ContentPosition::find($id);

        return view('content-position.edit', compact('contentPosition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  ContentPosition $contentPosition
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ContentPosition $contentPosition)
    {
        $generalService = new GeneralService();
        request()->validate(ContentPosition::$rules);
        if (count($request->details)){
            foreach ($request->details as $key=>$val){
                $contentPositionDetail = ContentPositionDetail::find($key);
                $contentPositionDetail->sequence = $val;
                $contentPositionDetail->save();
            }
        }
        if ($contentPosition->slots > $request->slots){
            $remove =  $contentPosition->slots - $request->slots;
            ContentPositionDetail::latest()->take($remove)->delete();
        }
        $details = $contentPosition->details;
        $count = count($details);
        $lastSequence = $details[$count-1]->sequence;

        if ($count < $request->slots){

            for ($i = $contentPosition->slots; $i <= $request->slots;$i++){
                $lastSequence++;
                ContentPositionDetail::create([
                    'content_position_id' => $contentPosition->id,
                    'sequence' => $lastSequence,
                    'type'=>$request->content_type
                ]);
            }
        }

        $contentPosition->update($request->all());
        Cache::forget('sidebar');
//        $purgeCache = $generalService->clear_cache_cloudflare('contentPosition',0);
        return redirect()->route('content-positions.index')->with('success', 'ContentPosition updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contentPosition = ContentPosition::find($id);
        $contentPosition->details()->delete();
        $contentPosition->delete();
        Cache::forget('sidebar');
        return redirect()->route('content-positions.index')->with('success', 'ContentPosition deleted successfully');
    }
    public function contentPosts($id){
        $contentPosition = ContentPosition::find($id);
        if (!$contentPosition) { return abort('404'); }
        $posts = [];
        if (json_decode($contentPosition->posts) != null){
            $posts = Post::whereIn('id',json_decode($contentPosition->posts))->get();
        }
        return  view('content-position.posts',compact('contentPosition','posts'));
    }

    public function addContentPositionPost(Request $request){
        $contentPosition = ContentPosition::find($request->content_position_id);
        if (!$contentPosition) { return abort('404'); }
        if ($contentPosition->posts == null){
            $posts = [$request->postId];
        }else{
            $posts = json_decode($contentPosition->posts);
            if (in_array($request->postId,$posts)){
                return 0;
            }
            array_push($posts,$request->postId);
        }
        $contentPosition->posts = json_encode($posts);
        $contentPosition->save();
        return true;
    }
    public function removeContentPositionPost(Request $request){
        $contentPosition = ContentPosition::find($request->content_position_id);
        if (!$contentPosition) { return abort('404'); }
        $posts = json_decode($contentPosition->posts);
        $postsNew = [];
        foreach ($posts as $post){
            if ($request->postId != $post){
                array_push($postsNew,$post);
            }
        }

        $contentPosition->posts = json_encode($postsNew);
        $contentPosition->save();

        return  true;
    }
}
