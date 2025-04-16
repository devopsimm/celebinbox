<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Spatie\Searchable\Search;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends Controller
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
        if (!request()->user()->can('tags.view')){
            return abort('403');
        }
        $tags = Tag::paginate();

        return view('admin.tag.index', compact('tags'))
            ->with('i', (request()->input('page', 1) - 1) * $tags->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('tags.create')){
            return abort('403');
        }
        $tag = new Tag();
        return view('admin.tag.create', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('tags.create')){
            return abort('403');
        }
        request()->validate(Tag::$rules);
        $tags = explode(',',$request->tags);
        foreach ($tags as $tag){
            $tag = Tag::create(['name'=>$tag]);
        }


        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('tags.view')){
            return abort('403');
        }
        $tag = Tag::find($id);

        return view('admin.tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('tags.edit')){
            return abort('403');
        }
        $tag = Tag::find($id);

        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tag $tag)
    {
        if (!request()->user()->can('tags.edit')){
            return abort('403');
        }
        request()->validate(Tag::$rules);

        $tag->update($request->all());

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('tags.delete')){
            return abort('403');
        }

        $tag = Tag::find($id);
        $tag->posts()->detach();
        $tag->products()->detach();

        $tag->delete();
        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully');
    }

    public function getTags($term){
        $searchResults = (new Search())
            ->registerModel(Tag::class, 'name')
            ->search($term);
        $tags = [] ;
        foreach ($searchResults as $searchResult){
            $tags[] = $searchResult->searchable->name;
        }
        return json_encode($tags);


    }
}
