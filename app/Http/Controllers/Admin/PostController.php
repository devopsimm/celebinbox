<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\General\Helper;
use App\Models\Category;
use App\Models\Feed;
use App\Models\Post;
use App\Models\PostMeta;
use App\Services\AiService;
use App\Services\AnthropicService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use App\Services\PostService;
use phpDocumentor\Reflection\Types\True_;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class  PostController extends Controller
{
    public GeneralService $gService;
    public string $viewFolder = 'post';

    public function __construct()
    {
        $this->gService = new GeneralService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {


        if (!request()->user()->can('posts.view')){
            return abort('403');
        }
        $postService = new PostService();
        if ($request->filter){
            $filters = $request->filter;
        }else{
            $filters = [];
//            $filters['publish_status'] = [1];
        }
        $posts = $postService->index($request,'detailed',null,false,$filters);
    //    dd($posts);
        $feeds = Feed::all();

        $categories = Category::with('childCategories')->whereNull('parent_id')->orWhere('parent_id','0')->get();
        return view($this->viewFolder.'.index', compact('posts','categories','filters','feeds'))
            ->with('i', (request()->input('page', 1) - 1) * $posts->perPage());
    }
    public function indexByType(Request $request,$type)
    {

        if (!request()->user()->can('posts.view')){
            return abort('403');
        }
        $postService = new PostService();
        if ($request->filter){
            $filters = $request->filter;
        }else{
            $filters = false;
        }
        $posts = $postService->index($request,'detailed',$type,false,$filters);
        $categories = Category::with('childCategories')->whereNull('parent_id')->orWhere('parent_id','0')->get();

        return view($this->viewFolder.'.index', compact('posts','categories','filters','type'))
            ->with('i', (request()->input('page', 1) - 1) * $posts->perPage());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('posts.create')){
            return abort('403');
        }
        $postService = new PostService();
        $data = $postService->formData();
        $data['id'] = $postService->initializePost(auth()->id());

        return view($this->viewFolder.'.create')->with($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('posts.create')){
            return abort('403');
        }
        request()->validate(Post::$rules);
        $postService = new PostService();
        $data = $postService->save($request,auth()->id());
        if ($data['type'] == 'error') { return abort(404); }
        return redirect()->route('feed-posts.index')->with('success', $data['msg']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('posts.view')){
            return abort('403');
        }
        $postService = new PostService();
        $post = $postService->show($id);
        if ($post['type'] == 'error') { return abort(404); }
        return view($this->viewFolder.'.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('posts.edit')){
            return abort('403');
        }
        $postService = new PostService();
        $post = $postService->formData($id);
        if (($post['returnType'] == 'error')){ return abort('500'); }
        $post['id'] = $post['post']->id;
//        dd($post);
        $featuredImg = Helper::getFeaturedImg($post);
        $post['featuredImg'] = $featuredImg;
        return view($this->viewFolder.'.edit')->with($post);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $post)
    {
        if (!request()->user()->can('posts.edit')){
            return abort('403');
        }
        request()->validate(Post::$rules);
        $postService = new PostService();

        $data = $postService->save($request,auth()->id());
        if ($data['type'] == 'error') { return abort(404); }

        return redirect()->route('feed-posts.edit',$post)
            ->with('success', $data['msg']);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('posts.delete')){
            return abort('403');
        }

        $postService = new PostService();
        $data = $postService->delete($id);
        return redirect()->route('feed-posts.index')
            ->with('success', 'Post deleted successfully');
    }

    public function viewHistory($id,$metaId){
        $post = Post::find($id);
        $meta = PostMeta::find($metaId);
        return view($this->viewFolder.'.history', compact('post','meta'));
    }
    public function revertHistory($id, $metaId){
        $post = Post::find($id);
        $meta = PostMeta::find($metaId);

        $post->description = $meta->value;
        $post->save();
        return redirect()->route('feed-posts.edit',$post->id);
    }
    public function revertTitleHistory($id, $titleId, $excerptId){
        $post = Post::find($id);
        $title = PostMeta::find($titleId);
        $excerpt = PostMeta::find($excerptId);

        $post->title = $title->value;
        $post->excerpt = $excerpt->value;
        $post->save();
        return redirect()->route('feed-posts.edit',$post->id);
    }




    public function uploadEditorImages(Request $request){
        $postService = new PostService();
        $data = $postService->uploadEditorImages($request);
        return json_encode($data);
    }
    public function deleteEditorImages(Request $request){
        $postService = new PostService();
        $data = $postService->deleteEditorImages($request);
        return json_encode($data);
    }
    public function getRelatedPosts(Request $request){
        $postService = new PostService();
        $data = $postService->getRelatedPosts($request);
        return count($data)?json_encode($data):'404';
    }
    public function editorEmbeds(Request $request){
        $postService = new PostService();
        return $postService->editorEmbeds($request);

    }
    public function getAuthorsBySourceType(Request $request){
        $postService = new PostService();
        return $postService->getAuthorsBySourceType($request);
    }
    public function getAuthorsBySourceTypeForLiveBlog(Request $request){
        $postService = new PostService();
        return $postService->getAuthorsBySourceTypeForLiveBlog($request);
    }
    public function viewAdmin($slug){
        $service = new PostService();
        $slug = explode('-',$slug);
        $post = $this->gService->getRedisPostByID($slug[count($slug)-1],'db');
        if (!$post){ return abort('404'); }
        return view($this->viewFolder.'.show',compact('post'));
    }

    public function bulkPostSubmit(Request $request){
       $ids = $request->checkboxes;
        $service = new PostService();
        $service->postBulkAction($ids,$request->action);
    }

    public function rephraseTitle($id): \Illuminate\Http\RedirectResponse
    {
        $postMeta = new PostMeta();
        $service = new PostService();
        $gService = new GeneralService();
        $post = $service->show($id);
        $aiService = new AiService();
        $title = $post->title;
        $promptForTitle = "Please rewrite  given post title, it should be seo optimized and dont increase word count. Title:  {$title}";
        $titleResponse = $aiService->getResponse($promptForTitle,'word count should be same');
        if ($titleResponse['choices'][0]['message']['content']){

            if($post->org_title == ''){
                $post->org_title =$title;
            }
            $postMeta->create([
                'post_id'=>$id,
                'key'=>'title',
                'value'=>$title
            ]);


            $post->title = $titleResponse['choices'][0]['message']['content'];
            $post->slug = $gService->textToSlug($titleResponse['choices'][0]['message']['content']);
            $post->is_title_rephrased = 1;
            $post->save();
        }
        $this->rephraseExcerpt($id);
        return redirect()->route('feed-posts.edit',$post);
    }
    public function rephraseExcerpt($id)
    {
        $postMeta = new PostMeta();
        $service = new PostService();
        $post = $service->show($id);
        $aiService = new AiService();
        $excerpt = $post->excerpt;

        $promptForExcerpt = "Please rewrite  given post excerpt, it should be seo optimized and dont increase word count. Excerpt:  {$excerpt}";
        $titleResponse = $aiService->getResponse($promptForExcerpt,'word count should be same');
        if ($titleResponse['choices'][0]['message']['content']){
            if($post->org_excerpt == ''){
                $post->org_excerpt =$excerpt;
            }
            $postMeta->create([
                'post_id'=>$id,
                'key'=>'excerpt',
                'value'=>$post->excerpt
            ]);


            $post->excerpt = $titleResponse['choices'][0]['message']['content'];
            $post->is_excerpt_rephrased = 1;
            $post->save();
            //dd($post);
        }
        return true;
    //    return redirect()->route('feed-posts.edit',$post);
    }

    public function rephraseContent($id){
        $service = new PostService();
        $postMeta = new PostMeta();
        $post = $service->show($id);
        $aiService = new AiService();

        $htmlContent = ($post->description == '')?$post->description_org:$post->description;
        // Pass the HTML content directly to the AI
        $prompt = "Take the given HTML content and rewrite only the text within the tags while keeping all HTML elements, attributes, and images exactly as they are. Ensure the rephrased text is natural, engaging, and flows smoothly, as if written by a professional journalist. The news story should have a human touch, making it compelling and well-structured. Improve readability, fix any grammatical errors, and enhance clarity while maintaining the original meaning. Preserve the tone and context of the content, ensuring it feels authentic and well-articulated. Replace any <a> tags with <span> tags and remove the href attributes, but do not modify the structure or content of any other tags specially Image tag or Figure tag, just update the text.
        {$htmlContent}";
        $response = $aiService->getResponse($prompt);

        //$image = $aiService->generateImage($post->title,$post->id,$post->slug);
        if ($response['choices'][0]['message']['content']){
            $newDescription = ($response['choices'][0]['message']['content'] != '')?$response['choices'][0]['message']['content']:$post->description;
            if($post->description_org == ''){
                $post->description_org = $post->description;
            }
            $postMeta->create([
                'post_id'=>$id,
                'key'=>'description',
                'value'=>$post->description
            ]);
            $post->description = $newDescription;

            //  $post->featured_image = $image;
            $post->is_rephrase = 1;
        }
        $post->save();
        return redirect()->route('feed-posts.edit',$post);

    }



    public function revertOriginal(Request $request,$id){
        $post = Post::find($id);
        if (!$post){ return abort(404);exit(); }
        if ($post->org_title != null){
            $post->title = $post->org_title;
            $post->is_title_rephrased = 0;
        }

        if ($post->org_excerpt != null){
            $post->excerpt = $post->org_excerpt;
            $post->is_excerpt_rephrased = 0;
        }

        if ($post->description_org != null){
            $post->description = $post->description_org;
            $post->is_rephrase = 0;
        }


        $post->save();

        return redirect()->route('feed-posts.edit',$post);


    }






    public function test(){
        return view($this->viewFolder.'.test');
    }
    public function testUpload(Request $request){
        $serviceImg = $this->gService->uploadImgTest($request->image,'posts/featureImages','postThumbnails');
        dd($request->all());
    }






}
