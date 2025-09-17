<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\GeneralService;
use App\Services\PostService;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function view(){
        //dd('here');
        $categories = Category::where('parent_id','0')->orWhere('parent_id',null)->with('childCategories')->get();
        return view('rss.show',compact('categories'));
    }

    public function generate($category,$subCategory = false){
        $postService = new PostService();
        $generalService = new GeneralService();

        if (!$subCategory){
            $posts = $postService->postsByCatId('redis',$category,'desc','10',false,'1');
            $category = $postService->getCatFromId($category);
        }else{
            $posts = $postService->postsByCatId('redis',$subCategory,'desc','10',false,'1',$subCategory);
            $category = $postService->getCatFromId($subCategory);
        }

        $description = isset(json_decode($category->seo_details)->description)?json_decode($category->seo_details)->description:'';
        return response()->view('rss.feed', [
            'category'=>$category,
            'posts' => $posts,
            'description' =>$description,
        ])->header('Content-Type', 'text/xml');

    }

}
