<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\GeneralService;
use App\Services\PostService;
use App\Services\WebService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WebController extends Controller
{

    private GeneralService $gService;
    private PostService $postService;

    public function __construct()
    {
        $this->gService = new GeneralService();
        $this->postService = new PostService();
    }

    public function homePage(Request $request){
//dd('here');
        $webService = new WebService();
        $data = $webService->homePageData($request);
        return view('website/home')->with($data);
    }


    public function categoryPage(Request $request,$cat){
        $category = false;
        $page = 'category';

        $category = $this->gService->getCategory($cat);

        if(!$category){ return Redirect::to('/','301'); }
        $pageName = $category->name;
        $loadMoreRoute = route('loadMorePosts',['type'=>'category','id'=>$category->id]);
        $meta = [];
        $postCount = 10;
        $posts = $this->postService->postsByCatId('redis',$category->id,'desc',$postCount,false,'1');
      //  dd($posts);

        return view('website.postCategories',compact('posts','meta','page','pageName','loadMoreRoute','category'));
    }
    public function getSubCatsForCatPage($category){
        $postService = new PostService();
        $generalService = new GeneralService();
        $data = [];
        $subcategories = $category->childCategories;
        foreach ($subcategories as $subcategory){
            $posts = $generalService->postsByCatId('redis',$category->id,'desc',5,false,'1',$subcategory->id);

            $data[] = [
                'posts' => $posts,
                'category'=>$category,
                'subCategory' => $subcategory
            ];
        }

        return $data;
    }

    public function latest(){
        $postService = new PostService();
        $posts = $postService->postsByLatest(20);
        $pageName = 'Latest Posts';
        return view('website.latest',compact('posts','pageName'));
    }
    public function loadMorePosts(Request $request,$type,$id=false){
        $postService = new PostService();
        $generalService = new GeneralService();
        $posts = [];
        $collectionType = 'redis';

        if ($type == 'category'){
            $posts = $postService->postsByCatId('redis',$id,'desc',$request->limit,false,$request->page);
        }
        if ($type == 'subCategory'){
            $posts = $postService->postsByCatId('redis',$id,'desc',$request->limit,false,$request->page,$id);
        }
        if ($type == 'author'){
            $posts = $postService->postsByAuthor($request,'redis',['id'=>$id],'desc',$request->limit,false,$request->page);
            if (!$posts){ return false; }
            $posts = $posts['posts'];
        }
        if ($type == 'tag'){
            $posts = $postService->postsByTag($request,'redis',['id'=>$id],'desc',$request->limit,false,$request->page);
            if (!$posts){ return false; }
            $posts = $posts['posts'];
        }
        if (!count($posts)){
            return '404';
        }

        // TODO: handle without cat id requests
        if ($request->returnType == 'html'){
            return view('layouts.partials.web.loadMorePostsContainer',compact('posts'))->render();
        }
        return  json_encode($posts);


    }


    public function postDetails(Request $request,$slug){
        $generalService = new GeneralService();
        $webService = new WebService();
        $service = new PostService();
        $slug = explode('-',$slug);
        if (!$generalService->checkIfDotInId($slug[0])){
            return Redirect::to('/','301');
        }
        $post = $service->getRedisPostByID($slug[0]);
        if (!$post){ return Redirect::to('/','301'); }
        if ($post->is_published != 1){ return Redirect::to('/','301'); }
        $isVerifiedSlug =  $generalService->verifyPostSlug($slug,$post);
    //    dd($isVerifiedSlug);
        if (!$isVerifiedSlug){
            return redirect(route('slugPage',$post->slug.'-'.$post->id));
        }
        $description = $service->parseDescription($post->description,$post->title);
        $description = $generalService->processImagesInHtml($description,$post->title);

        if (count($post->relatedPosts)){
            $relatedPosts = $post->relatedPosts;
        }else{
            $relatedPosts = $service->postsByCatId('redis',$post->category_id,'desc',17);
            $sideBarRelatedPosts = array_slice($relatedPosts, 0, 5); // First 5 posts
            $relatedPosts = array_slice($relatedPosts, 5);
        }


        $metas = $generalService->postMetaKeyWise($post->meta);

//        $nextPrevPost = $service->getNextPrevPost($post);
        return view('website.detailPage',compact('post','description','relatedPosts','metas','sideBarRelatedPosts'));


    }

}

