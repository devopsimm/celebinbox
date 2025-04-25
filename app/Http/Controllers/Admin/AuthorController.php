<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
/**
 * Class AuthorController
 * @package App\Http\Controllers
 */
class AuthorController extends Controller
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
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $authors = Author::paginate();

        return view('admin.author.index', compact('authors'))
            ->with('i', (request()->input('page', 1) - 1) * $authors->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $author = new Author();
        return view('admin.author.create', compact('author'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $except = ['photo'];
        request()->validate(Author::$rules);
//        $imgData = array(
//            'data'=>$request,
//            'returnType'=>'request',
//            'request_name'=>'photo',
//            'request_name_new'=>'profile_picture',
//            'folder_name'=>'authors',
//            'file_name'=>'author',
//        );
//        $request = $this->gService->manageAttachment($imgData);

        $data = $request->except($except);
        if ($request->file('photo')) {
            $data['profile_picture'] = $this->gService->uploadImg($request->file('photo'), 'authors/featureImages');
        }
        $author = Author::create($data);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $author = Author::find($id);

        return view('admin.author.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $author = Author::find($id);

        return view('admin.author.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Author $author)
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        $except = ['photo'];
        request()->validate(Author::$rules);

        $data = $request->except($except);
        if ($request->file('photo')){
            $data['profile_picture'] = $this->gService->uploadImg($request->file('photo'),'authors/featureImages');
        }


        $author->update($data);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('manageAuthors')){
            return abort('403');
        }
        Author::find($id)->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully');
    }
}
