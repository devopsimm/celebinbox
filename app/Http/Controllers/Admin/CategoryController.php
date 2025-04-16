<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\General\Helper;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
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
        if (!request()->user()->can('categories.view')){
            return abort('403');
        }
        $categories = Category::with('parentCategories')->paginate();

        return view('category.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * $categories->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('categories.create')){
            return abort('403');
        }
        $category = new Category();
        $parentCategories = $category::whereNull('parent_id')->orWhere('parent_id','0')->get();
        $seoTags = ['title'=>'','description'=>'','keywords'=>''];
        return view('category.create', compact('category','parentCategories','seoTags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('categories.create')){
            return abort('403');
        }
        request()->validate(Category::$rules);
        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description

        ];

        if ($request->file('photo')){
            $data['image'] = $this->gService->uploadImg($request->file('photo'),'category');
        }
        if ($request->parent_id != 'None'){
            $data['parent_id'] = $request->parent_id;
        }
        if (isset($request->is_featured)){
            $data['is_featured'] = 1;
        }else{
            $data['is_featured'] = 0;
        }
        $data['seo_details'] = json_encode($request->seo);
        $data['slug'] = Helper::nameToUrl($request->name);
        Category::create($data);
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('categories.view')){
            return abort('403');
        }
        $category = Category::find($id);
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('categories.edit')){
            return abort('403');
        }
        $category = Category::find($id);
        $parentCategories = $category::whereNull('parent_id')->orWhere('parent_id','0')->get();
        if ($category->seo_details == null){
            $seoTags = ['title'=>'','description'=>'','keywords'=>''];
        }else{
            $seoTags = (Array) json_decode($category->seo_details);
        }

        return view('category.edit', compact('category','parentCategories','seoTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        if (!request()->user()->can('categories.edit')){
            return abort('403');
        }
        request()->validate(Category::$rules);
        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description
        ];
        if ($request->file('photo')){
            $this->gService->removePreviousImg($category->image);
            $data['image'] = $this->gService->uploadImg($request->file('photo'),'category');
        }
        if ($request->parent_id != 'None'){
            $data['parent_id'] = $request->parent_id;
        }
        if (isset($request->is_featured)){
            $data['is_featured'] = 1;
        }else{
            $data['is_featured'] = 0;
        }
        $data['seo_details'] = json_encode($request->seo);

        $data['slug'] = Helper::nameToUrl($request->name);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('categories.delete')){
            return abort('403');
        }
        Category::find($id)->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
    public function getChildCategories(Request $request){
        $post = Post::find($request->postId);
        $postCategories = $post->categories()->pluck('name','categories.id')->toArray();
        $dbCategories = Category::where('parent_id',$request->categoryId)->pluck('name','id')->toArray();
        if (!count($dbCategories)){ return '404'; }
        $categories = [];
        foreach ($dbCategories as $key=>$dbCategory){
            $data = [
                'id'=>$key,
                'name'=>$dbCategory,
            ];
            if (isset($postCategories[$key])){
                $data['selected'] = 'yes';
            }else{
                $data['selected'] = 'no';
            }
            array_push($categories,$data);
        }
        return json_encode($categories);
    }
}
