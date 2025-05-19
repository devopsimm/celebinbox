<?php

namespace App\Services;


use App\Http\Helpers\General\Helper;
use App\Models\Author;
use App\Models\Category;
use App\Models\ContentPosition;
use App\Models\ContentPositionDetail;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostMeta;
use App\Models\PostView;
use App\Models\Tag;
use App\Models\Template;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Session;
use App\Services\GalleryService;


class PostService
{

    private $slug;
    public array $PostExcept = ['_token','_method', ];

    public array $return =  ['type'=>'success','msg' => 'Post saved successfully'];
    private GeneralService $gService;

    public function __construct()
    {

    }
    public function index($request,$type='detailed',$publishStatus = 1,$cat = false,$filters=false,$perPage=false){


        if ($cat != false){
            $catId = Category::where('slug',$cat)->first();
            if ($catId){
                $catId = $catId->id;
            }else{
                $catId = false;
            }
        }

        $posts = Post::where('status','!=','0');
        if ($cat != false){
            $posts = $posts->where('category_id',$catId);
        }
        if ($publishStatus != null){
            $posts = $posts->where('is_published',$publishStatus);
        }

        if ($filters){
            if (isset($filters['categories'])){
                $posts = $posts->whereIn('category_id',$filters['categories']);
            }
            if (isset($filters['feeds'])){
                $posts = $posts->whereIn('feed_id',$filters['feeds']);
            }
            if (isset($filters['publish_status'])){
                $posts = $posts->whereIn('is_published',$filters['publish_status']);
            }

            if (isset($filters['startDate'])){
                $date = $filters['startDate'];
                $date = Carbon::parse($date);
                $posts = $posts->whereDate('posted_at','>=',$date);
            }
            if (isset($filters['endDate'])){
                $date = $filters['endDate'];
                $date = Carbon::parse($date);
                $posts = $posts->whereDate('posted_at','<=',$date);
            }

        }
        if ($request->user_id){
            $posts = $posts->where('user_id',$request->user_id);
        }

        if ($request->search){
            $posts = $posts->where('title','LIKE','%'.$request->search.'%');
        }

        if ($type == 'all'){
            return $posts->get();
        }
        if ($type == 'simple'){
            return $posts->orderBy('id','desc')->simplePaginate();
        }else{
            if($publishStatus == 0){

                return $posts->orderBy('updated_at','desc')->paginate();
            }


            return $posts->orderBy('posted_at','desc')->paginate();
        }





    }

    public function
    formData($id = false): array
    {

        $Post = new Post();
        $tags = false;
        $pushNotifications = [];
        $socialSharing = [];
        $metas = [];
        $selectedAuthors = [];
        $relatedPosts = [];
        $postPositions = [];
        $description = '';
        $descriptionOrg = false;
        if ($id){
            $Post = $Post::find($id);
            if (!$Post) {
                $this->return['msg'] = 'Post Not Found';
                $this->return['returnType'] = 'error';
                return  $this->return;
            }
            if ($Post->description != null){
                $description = $this->parseDescriptionForEdit($Post->description);
            }
            if ($Post->description_org != null){
                $descriptionOrg = $this->parseDescriptionForEdit($Post->description_org);
            }
            $tags = $Post->tags()->pluck('name')->toArray();
            $tags = implode(',',$tags);
            if ($Post->push_notification != null){
                $pushNotifications = json_decode($Post->push_notification);
            }
            if ($Post->social_sharing != null){
                $socialSharing = json_decode($Post->social_sharing);
            }
            $metas = $Post->meta()->where('value','!=','false')->pluck('value','key')->toArray();
            $descriptionHistoryItems = $this->getDescriptionHistoryItems($Post->meta);

            $relatedPosts = $Post->relatedPosts()->pluck('posts.title','posts.id')->toArray();
            $postPositions = ContentPositionDetail::where('model_id',$id)->where('type','1')->pluck('id')->toArray();

        }


        return [
            'returnType'=>'success',
            'post' => $Post,
            'contentPositions' => ContentPosition::where('content_type',1)->get(),
            'categories' => Category::whereNull('parent_id')->orWhere('parent_id','0')->get(),
            'tags'=>Tag::all(),
            'templates'=>Template::all(),
            'selectedTags'=>$tags,
            'pushNotifications'=>$pushNotifications,
            'socialSharing'=>$socialSharing,
            'metas' => $metas,
            'relatedPosts' => $relatedPosts,
            'description'=> $description,
            'descriptionOrg'=>$descriptionOrg,
            'postPositions' =>$postPositions,
            'descriptionHistoryItems' => $descriptionHistoryItems
        ];
    }
    public function getDescriptionHistoryItems($metas){
        $items = [];
        if (count($metas) != 0){
            foreach ($metas as $meta){
                if ($meta->key == 'description'){
                    $items[] = $meta;
                }
            }
        }
        return $items;
    }
    public function parseDescriptionForEdit($description){
        $description = str_replace('class="specedit"','class="specedit"  contenteditable="true"',$description);
        $description = str_replace('class="specedit valid"','class="specedit valid" contenteditable="true"',$description);
        $description = html_entity_decode($description);

        return $description;
    }
    public function save($request,$userId){
        $sendNotification = false;


        $postId = $request->post_edit_id;
        $post = Post::find($postId);

        if (!$post){ return abort('404'); }

        $this->managePostMeta($request,$postId);

        $data = [
            'template_id'=>$request->template_id,
            'category_id'=>$request->parent_category,
            'title'=>$request->title,
            'excerpt'=>$request->excerpt,
            'type'=>$request->source_type,
            'is_published'=>$request->is_published,
            'status'=>1
        ];

        if ($post->user_id == 1){
            $data['user_id'] = $userId;
        }
        if ($post->user_id == null){
            $data['user_id'] = $userId;
        }

        if ($request->canonical_url != null){
            $data['canonical_url'] = $request->canonical_url;
        }else{
            $data['canonical_url'] = '';
        }
        if ($request->canonical_source != null){
            $data['canonical_source'] = $request->canonical_source;
        }else{
            $data['canonical_source'] = '';
        }
        if ($request->story_highlights != null){
            $data['story_highlights'] = $request->story_highlights;
        }else{
            $data['story_highlights'] = '';
        }
        if ($request->app_title != null){
            $data['app_title'] = $request->app_title;
        }else{
            $data['app_title'] = $request->title;
        }
        if ($request->pushNotifications){
            $data['push_notification'] = json_encode($request->pushNotifications);
            $sendNotification = true;
        }else{
            $data['push_notification'] = '';
        }
        if ($request->socialSharings){
            $data['social_sharing'] = json_encode($request->socialSharings);
        }else{
            $data['social_sharing'] = '';
        }
        if ($request->file('image')){
            $data['featured_image'] = $this->addFeatureImg($request->file('image'));
        }
        $data['show_video_icon'] = (isset($request->show_video_icon)) ? 1 : 0;


        $data['posted_at'] = Helper::convertDateFormat($request->posted_at,'24');
        // dd( $data['posted_at'] );

        $data['description'] = $this->parseDescriptionBeforeSave($request,$data);
        $data['slug'] = $this->getSlug($request);

        $this->saveTags($post,$request->tags);

        $this->saveCategories($post,$request->categories);


        $this->saveAuthors($post,$request->author_ids);

        $this->saveRelatedPosts($post,$request->relatedPostIds);

        $this->saveContentPositions($request->post_edit_id,$request->content_positions);



        Post::where('id',$postId)->update($data);
//        if ($sendNotification){
//            $this->sendPushNotification($postId);
//        }
//        $purgeCache = $this->gService->clear_cache_cloudflare('post',$post->id);
        $this->purgeRedisCache('postUpdate',$postId);
       $this->cacheKeys('all');
      //  $purgeCache = $this->gService->clear_cache_cloudflare('post',$post->id);
      //  $this->gService->purgeRedisCache('postUpdate',$postId);

        $this->return['msg'] = 'Post saved successfully.';
        Helper::AddActivity($post->id,'App\Models\Post',$this->return['msg']);
//        event(new PostUpdateEvent());
        return $this->return;
    }

    public function sendPushNotification($id,$type='firebase'){
        $post = Post::find($id);

        $fields = array();
        $fields['notification'] = array(
            'title' =>  $post->title,
            'body' =>  $post->excerpt,
            'click_action' =>  route('slugPage',$post->slug.'-'.$post->id),
            'icon' =>  url('website/img/favicon/ms-icon-144x144.png'),
            'image' =>  Helper::getFileUrl($post->featured_image,$post,'post')
        );

        $fields['to'] = "/topics/all";


        return $this->sendOnsignalNotification($fields);

    }
    public function sendOnsignalNotification($data){
        $appId = env('ONESIGNAL_APP_ID');
        $apiKey = env('ONESIGNAL_REST_API_KEY');

        $notificationTitle = $data['notification']['title'];
        $notificationBody = $data['notification']['body'];
        $notificationUrl = $data['notification']['click_action'];

        $ch = curl_init('https://onesignal.com/api/v1/notifications');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $apiKey,
        ]);

        $payload = json_encode([
            'app_id' => $appId,
            'included_segments' => ['Total Subscriptions'], // Add the device token here
            'headings' => ['en' => $notificationTitle],
            'contents' => ['en' => $notificationBody],
            'url' => $notificationUrl, // Optional: URL to open on click
            'big_picture' => $data['notification']['image'],
            'chrome_web_image' => $data['notification']['image'],
            'huawei_big_picture' => $data['notification']['image'],
            'adm_big_picture' => $data['notification']['image'],
            'chrome_big_picture' => $data['notification']['image'],
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            echo 'Response: ' . $response;
        }

        curl_close($ch);
    }

    public function sendFirebaseNotification($fields){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: key=AAAAswZngic:APA91bHqP_kDHMlhXyw9WzXo3hthWZBSq1nCswUAhDsSqtjNhS7CjkCBG1g7PAN6HBxtjLeKnitak4tax_P6In4hWk9t6BMTU_HGiZTKfddo-iD9yUkTb66SxbE2gQbCZsdwiGyZzrO7",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        // dd($response);
        return $response;
    }

    public function saveContentPositions($postId,$contentPositions): void
    {


        // ContentPositionDetail::where('model_id',$postId)->where('type',1)->update(['model_id'=>null]);
        if ($contentPositions != null) {
            foreach ($contentPositions as $contentPosition) {

                $contentPosition = ContentPositionDetail::find($contentPosition);
                $getContentPositions = ContentPositionDetail::where('content_position_id',$contentPosition->content_position_id)
                    ->where('sequence','>=',$contentPosition->sequence)->orderBy('sequence','asc')->get();
                $oldPostId = null;
                if ($getContentPositions[0]->model_id != $postId){
                    foreach ($getContentPositions as $getContentPosition ){
                        if ($oldPostId == null){
                            $oldPostId = $getContentPosition->model_id;
                        }else{
                            $cp = ContentPositionDetail::find($getContentPosition->id);
                            $currentPostId = $cp->model_id;
                            $cp->model_id = $oldPostId;
                            $cp->save();
                            $oldPostId = $currentPostId;
                        }
                    }
                    $contentPosition->model_id = $postId;
                    $contentPosition->save();
                }


            }
        }
        ///dd('121');
    }


    public function parseDescriptionBeforeSave($request,$data){
        $description = $request->description;
        if ($request->file('image')){
            if(strpos($description, 'mobile_specification')){
                $upload_image_url = '/'.$data['featured_image'];
                $description = str_replace('class="specs-photo-main"', 'class="specs-photo-main" style="background-image: url('.$upload_image_url.');"', $description);
            }
        }
        $description = str_replace('class="specedit" contenteditable="true"','class="specedit"',$description);
        $description = str_replace('class="specedit valid" contenteditable="true"','class="specedit valid"',$description);
        $description = html_entity_decode($description);

//        $keywords = Keyword::where('status','1')->pluck('link','keyword');
//        foreach ($keywords as $keyword=>$link){
//            //$link = '<a href="'.$link.'" target="_blank">'.$keyword.'</a>';
//            $link = "<a href='".$link."' target='_blank'>".$keyword."</a>";
//            //$description = str_replace($keyword,$link,$description);
//            $description = $this->str_replace_first($keyword,$link,$description);
//        }
        return $description;
    }
    public function str_replace_first($keywordToReplace, $replacementValue, $htmlContent)
    {
        return $htmlContent;
//        $keywordToReplace = "Shark";
//        $htmlContent = preg_replace('/(<(?:[^>]*\bclass="image-caption"[^>]*>|[^>]*\balt=".*?'.$search.'.*?"[^>]*>)[^<]*)'.$search.'([^<]*)/i', '$1'.$replace.'$2', $subject, 1);
//        return $htmlContent;
//        $search = '/'.preg_quote($search, '/').'/';
//        return preg_replace($search, $replace, $subject, 1);
//      // Create a DOMDocument instance
//// Create a DOMDocument
//        $dom = new DOMDocument;
//        $dom->loadHTML("<div>".$htmlContent."</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
//
//// Create a DOMXPath object
//        $xpath = new \DOMXPath($dom);
//// Exclude alt attribute and figcaption text
//        $exclusionXpath = '//img[@alt] | //figcaption';
//
//// Query elements to exclude
//        $excludeElements = $xpath->query($exclusionXpath);
//
//// Replace the first occurrence of the keyword
//        $keywordFound = false;
//
//
////        dd($xpath->query('//text()[contains(., "'.$keywordToReplace.'")]'));
//        foreach ($xpath->query('//text()[contains(., "'.$keywordToReplace.'")]') as $textNode) {
//            dd(iterator_to_array($excludeElements));
//            dd($textNode->parentNode);
//            if (!in_array($textNode->parentNode, iterator_to_array($excludeElements))) {
//                $textNode->nodeValue = str_replace($keywordToReplace, $replacementValue, $textNode->nodeValue);
//                $keywordFound = true;
//
//            }
//        }
//
//// Output the modified HTML
//        $modifiedHtmlContent = $dom->saveHTML();
//dd('here');
//        return $modifiedHtmlContent;
//

    }

    public function saveTags($post,$tags){
        $Tag = new Tag();
        $tags = explode(',',$tags);
        $tagIds = [];
        foreach ($tags as $tag){
            $tag = $Tag::firstOrCreate(['name'=>$tag]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
        return true;
    }
    public function saveCategories($post,$categories){
        if ($categories == null){ $categories = []; }
        $post->categories()->sync($categories);
        return true;
    }
    public function saveAuthors($post,$authors){
        $post->authors()->sync($authors);
        return true;
    }
    public function saveRelatedPosts($post,$relatedPost){
        // dd($post->relatedPosts);
        $post->relatedPosts()->sync($relatedPost);
        return true;
    }
    public function addFeatureImg($img){
        $gService = new GeneralService();
        $serviceImg = $gService->uploadImg($img,'posts/featureImages','postThumbnails');
        return $serviceImg;
    }
    public function getSlug($request,$i=1){
        if ($request->slug == null){
            $title = $request->title;

            $slug = Helper::textToSlug($title);
            $category = Category::find($request->parent_category);
            if (!$category){ return abort(404); }
            $categorySlug = $category->slug;

            $slug = $slug.'-'.$categorySlug;

        }else{
            $slug = $request->slug;
            $slug = Helper::textToSlug($slug);
        }
//        $slug = $slug.'-'.$request->post_edit_id;
        return $slug;
    }
    public function managePostMeta($request,$postId,$type = 'checkbox'){
        $postMeta = new PostMeta();
        $checkBoxesConfig = config('settings.postMetaCheckBoxes');
        $inputsConfig = config('settings.postMetaInputs');
        $meta = $request->meta;
        if ($meta == null) { $meta = []; }
        $metas = array_merge($meta,$request->metaInputs);

        $this->initializePostMetas($postId);
        foreach ($metas  as $key => $meta){
            if (isset($inputsConfig[$key])){
                $val = $meta;
            }else{
                $val = 'true';
            }
            $postMeta::where('key',$key)->where('post_id',$postId)->update(['value'=>$val]);
        }
        foreach ($checkBoxesConfig as $key=>$value){
            if (!isset($metas[$key])){
                $postMeta::where('key',$key)->where('post_id',$postId)->update(['value'=>'false']);
            }
        }

        return true;
    }
    public function initializePostMetas($postId): bool
    {
        $configKeysOne = config('settings.postMetaCheckBoxes');
        $configKeysTwo = config('settings.postMetaInputs');
        $configKeys = array_merge($configKeysTwo,$configKeysOne);
//        dd($configKeys);
        $postMeta = new PostMeta();
        foreach ($configKeys as $key=>$config){
            $postMeta::firstOrCreate([
                'post_id'=>$postId,
                'key'=>$key,
            ],['value','false']);
        }
        return true;
    }
    public function update($request,$post){

        dd($request->all());


        $this->return['msg'] = 'Post updated successfully.';
        return $this->return;
    }
    public function show($id){
        $post = Post::find($id);
        if (!$post) {
            $this->return['msg'] = 'Post Not Found';
            $this->return['type'] = 'error';
        }
        return $post;

    }
    public function delete($id){
        $post = Post::find($id);
        if (!$post) {
            $this->return['msg'] = 'Post Not Found';
            $this->return['type'] = 'error';
        }
        $post->meta()->delete();
        $post->delete();
        $this->return['msg'] = 'Post Deleted';
        $this->return['type'] = 'success';
        return $this->return;

    }
    public function initializePost($id){
        $post = Post::create(['user_id'=>$id,'is_published'=>0,'status'=>0]);
        $this->initializePostMetas($post->id);
        return $post->id;
    }
    public function uploadEditorImages($request){
        $gService = new GeneralService();
        $data = $request->all();
        $data = [];
        $i = 0;
        foreach ($request->file('files') as $file){
            $img = $gService->uploadImg($file,'posts');
            $dimensions = getimagesize($file);
            $width =$dimensions[0];
            $height =$dimensions[1];
            $data['files'][$i] =  [
                'url'=>url($img),
                'width'=>$width,
                'height' => $height,
            ];
            PostImage::create([
                'post_id'=>$request->post_id,
                'image'=>$img,
            ]);
            $i++;
        }
        return $data;
    }
    public function deleteEditorImages($request){
        $file = explode('/',$request->file);
        $file = $file[count($file)-1];
        $gService = new GeneralService();
        $gService->removePreviousImg('storage/posts/'.$file);
        return true;
    }
    public function getRelatedPosts($request){
        $keyword = $request->search;
        $posts = Post::where('title','LIKE','%'.$keyword.'%')->pluck('title','id')->toArray();
        return $posts;
    }


    public function convertYoutube($url = '') {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe class=\"youtube-video\" style=\"width:100%;height:350px;\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
            $url
        );
    }
    public function getVimeoVideoIdFromUrl($url = '') {
        return preg_replace('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im',
            "<iframe style=\"width:100%;height:350px;\"  src=\"//player.vimeo.com/video/$3\" allowfullscreen></iframe>",
            $url);
    }
    function getUrlContentCard($html,$postUrl)
    {
        $data = array();
        $title = '';
        $description = '';
        $url = '';
        $image = '';
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');
        //$title = $nodes->item(0)->nodeValue;

        if ($nodes->length > 0) {
            $title = $nodes->item(0)->nodeValue;
            $metas = $doc->getElementsByTagName('meta');
            $link = $doc->getElementsByTagName('link');
            $description = "";
            $image = "";
            for ($i = 0; $i < $metas->length; $i++) {
                $meta = $metas->item($i);
                if ($meta->getAttribute('name') == 'description')
                    $description = $meta->getAttribute('content');
                if ($meta->getAttribute('name') == 'keywords')
                    $keywords = $meta->getAttribute('content');
                if ($meta->getAttribute('property') == 'og:image')
                    $image = $meta->getAttribute('content');

            }

            $icon = '';
            for ($j = 0; $j < $link->length; $j++) {
                $links = $link->item($j);

                if ($links->getAttribute('rel') == 'icon') {
                    $icon = $links->getAttribute('href');
                }else if ($links->getAttribute('rel') == 'shortcut icon'){
                    $icon = $links->getAttribute('href');
                }
            }

        } else {
            $icon = '';
            $data['is_bad'] = true;
        }

        $title1=explode('|',$title);
        $data["title"] = $title1[0];
        $data["description"] = $description;
        $data["url"] = $postUrl;
        $data["thumbnail_url"] = $image;
        $siteUrl = parse_url($postUrl);

        $data["html"] = '<div class="embed_external_url embedRelatedStory" style="width: 100%;height: 100%;"><a href="' . $postUrl . '" target="_blank"><img alt="CelebPost" class="relatedPostImage" src="' . $image . '"/><h4>' . $title1[0] . '</h4><p class="relatedPostDesc">' . $description . '</p></a><a class="iconArea" href="http://' . $siteUrl['host'] . '" target="_blank"><img class="relatedPostImage" src="' . $icon . '"/></a></div>';
        return $data;
    }
    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    public function editorEmbeds(Request $request){
        $url = $request->url;
        $html = $this->file_get_contents_curl($url);
        $data = array();
        $data['is_bad'] = false;
        $data['is_twitter'] = false;
        $tweeter = preg_match('/https:\/\/(www\.)*twitter\.com\/.*/', $url);
        $facebook = preg_match('/https:\/\/(www\.)*facebook\.com\/.*/', $url);
        $vimeo = preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url);
        $youtube = preg_match('/https:\/\/(www\.)*youtube\.com\/.*/', $url);
        $insta = preg_match('/https:\/\/(www\.)*instagram\.com\/.*/', $url);

        $checkIframe = preg_match("/<[^<]+>/", $url, $m) != 0;

        if (!$checkIframe) {

            if ($youtube) {
                $url = $this->convertYoutube($url);
                $data["html"] = '<div class="embed_external_url" style="width: 100%;height: 100%;">' . $url . '</div>';
            } else if ($vimeo) {
                $url = $this->getVimeoVideoIdFromUrl($url);
                $data["html"] = '<div class="embed_external_url" style="width: 100%;height: 100%;">' . $url . '</div>';
            } else if ($facebook) {
                if (stripos(strtolower($url), 'posts') !== false) {
                    $iframeFb = '<div style="float:left;" class="fb-post" data-href="' . $url . '" data-width="500" data-show-text="true"></div><div class="clearfix"></div>';
                }else{
                    $iframeFb = '<div style="float:left;" class="fb-video" data-href="' . $url . '" data-width="700" data-show-text="false"></div><div class="clearfix"></div>';
                }
                $iframeFb = '<iframe  class="faceBookIframe" src="https://www.facebook.com/plugins/post.php?href=' . $url . '" width="500" height="582" onload="resizeEmbedIframe(this)" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
                //  $data["html"] = '<div class="embed_external_url" style="width: 100%;height: 100%;">' . $iframeFb . '</div>';

            } else if ($tweeter) {
                $link_array = explode('/', $url);
                $id = end($link_array);
                $data['is_twitter'] = true;
                // $data["html"] = $id;
                $data["html"] = '<div class="embed_external_url tweetPost" id="' . $id . '" style="width: 100%;height: 100%;"><blockquote class="twitter-tweet" data-lang="en"><a href="' . $url . '"></a></blockquote></div>';
            }
            else if ($insta) {
                $data["isinsta"] = 1;
                // $data["html"] = $url;
                $data["html"] = '<div class="embed_external_url instagramPost"><blockquote class="instagram-media" data-instgrm-permalink="'.$url.'" data-instgrm-version="12"></blockquote></div>';
            }
            else if (!$tweeter && !$facebook && !$vimeo && !$youtube) {
                if (preg_replace(
                    '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
                    "'<a href=\"$1\" target=\"_blank\">$3</a>$4'",
                    $url
                )) {
                    $data = $this->getUrlContentCard($html, $url);
                }
            }
        }
        else if (substr_count($url, 'twitter-tweet')) {

            $dom = new DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $url = mb_convert_encoding($url, 'HTML-ENTITIES', "UTF-8");

            $dom->loadHTML($url);
            $dom->removeChild($dom->doctype);
            $dom->preserveWhiteSpace = false;

            $xpath = new DOMXpath($dom);

            $elements = $xpath->query("*//blockquote[@class='twitter-tweet']");

            $twitter_url = '';
            foreach ($elements as $elem) {

                $count_anchor = intval($elem->getElementsByTagName('a'));

                if($count_anchor > 0) {
                    $href = $elem->getElementsByTagName('a')->item($count_anchor)->getAttribute('href');
                    $href_array = explode('?', $href);
                    $twitter_url = $href_array[0];
                }
            }

            if($twitter_url != ''){
                $data['is_twitter'] = true;
                $link_array = explode('/',$twitter_url);
                $id = end($link_array);
                //$data["html"] = $id;
                $data["html"] = '<div class="embed_external_url tweetPost"  id="' . $id . '" style="width: 100%;height: 100%;"><blockquote class="twitter-tweet" data-lang="en"><a href="'.$twitter_url.'"></a></blockquote></div>';
            }
        }
        else {

            $data['is_bad'] = true;
        }
//dd($data);
        echo json_encode($data);
    }
    public function parseDescription($description,$title=false){
        $tag = 'embed_gallery';
        $galleryService = new GalleryService();

        if (stripos($description, $tag) !== false)
        {

            $gdom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $gdom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new \DOMXpath($gdom);
            $totalMatches = substr_count($description, 'geo_embedgallery');
            $description = "";
            for($g=1; $g<=$totalMatches; $g++){
                $elements = $xpath->query("//*[contains(attribute::class, 'embed_gallery".$g."')]");
                foreach ($elements as $e) {
                    $gid = $e->getAttribute("id");

                    $galleryhtml = $galleryService->getHtml($gid);

                    $frag = $gdom->createDocumentFragment();
                    $frag->appendXML($galleryhtml);

                    for ($i = $e->childNodes->length - 1; $i >= 0; $i--) {
                        $e->removeChild($e->childNodes->item($i));
                    }
//                    dd($frag);
                    $e->appendChild($frag);
                    $description = $e->ownerDocument->saveHTML();
                }
            }

        }

        $description = $this->embed_player_within_content($description,$title);
//        $description = $this->embbedKeyword($description);
        return $description;
    }

    public function embed_player_within_content($description,$title,$counter=5)
    {
        $content_url    = '';
        $BC_ACCOUNT_ID = '';
        $BC_PLAYER_ID = '';
        for ($abc = 1; $abc < $counter; $abc++)
        {
            $isVideoEmbed = stripos($description, "[embed_video" . $abc)?true:false;

            if ($isVideoEmbed)
            {
                $desc_explode       = explode('[embed_video' . $abc . ' url=', $description);
                $desc_explode       = explode('style=', $desc_explode[1]);
                $hls_video          = trim($desc_explode[0]);

                $style_video        = 'center';
                $is_header_video    = '';

                if (stripos($description, "[embed_video".$abc." url=".$hls_video." style=center playertype=bc]"))
                {
                    $bc_video_id = str_replace('videoid:', '', $hls_video);

                    if ($abc == 1 )
                        $content_url = 'https://players.brightcove.net/'.$BC_ACCOUNT_ID.'/'.$BC_PLAYER_ID.'_default/index.html?videoId='.$bc_video_id;

                    $desc_explode = explode(']', $desc_explode[1]);
                    $style_video  = trim($desc_explode[0]);
                    $embed_video  = $this->post_embed_video_player_bc(array('bc_video_id' => $bc_video_id));// call_user_func('post_embed_video_player_bc', array('bc_video_id' => $bc_video_id));
                    $description  = str_replace("[embed_video".$abc." url=videoid:".$bc_video_id." style=center playertype=bc]", $embed_video, $description);
                }
                else
                {
                    $params =array('count_embed_video' => $abc, 'post_title' => $title, 'style_video' => $style_video, "is_header_video" => $is_header_video);

                    if (stripos($description, "[embed_video".$abc." url=".$hls_video." style=center livestream=1]")) {
                        $hls_video_https            = $hls_video;
                        $params['hls_video_url']    = $hls_video_https;
                        $params['is_livestream']    = 1;

                        $embed_video                = $this->post_embed_video($params);//call_user_func('post_embed_video', $params);
                        $description                = str_replace("[embed_video".$abc." url=".$hls_video." style=center livestream=1]", $embed_video, $description);
                    }
                    else if (stripos($description, "[embed_video".$abc." url=".$hls_video." style=center 5cent=1]")) {
                        $hls_video_https            = $hls_video;
                        $params['hls_video_url']    = $hls_video_https;
                        $params['5cents']           = 1;

                        $embed_video                = $this->post_embed_video($params);//call_user_func('post_embed_video', $params);
                        $description                = str_replace("[embed_video".$abc." url=".$hls_video." style=center 5cent=1]", $embed_video, $description);
                    }
                    else {
                        $hls_video_https            = change_stream_url($hls_video, 1);
                        $params['hls_video_url']    = $hls_video_https;

                        $embed_video                = $this->post_embed_video($params);//call_user_func('post_embed_video', $params);
                        $description                = str_replace("[embed_video".$abc." url=".$hls_video." style=center]", $embed_video, $description);
                    }

                    if ($abc == 1 )
                        $content_url = !empty($hls_video_https) ? strtok($hls_video_https,'?') : '';
                }
            }
        }
        return $description;
    }
    public function post_embed_video($attr = array())
    {
        $hls_video_url = '';
        $count_embed_video = '';
        $style_video = '';
        $videoformat = 'application/x-mpegURL';
        $video_image_url = url('website/img/video_default_img.jpg');

        if (isset($attr['hls_video_url'])) {
            $hls_video_url = $attr['hls_video_url'];
        }
        if (isset($attr['count_embed_video'])) {
            $count_embed_video = intval($attr['count_embed_video']);
        }
        if (isset($attr['style_video'])) {
            $style_video = $attr['style_video'];
        }

        if(strpos($hls_video_url, '.mp4'))
            $videoformat = 'video/mp4';

        if(strpos($hls_video_url, 'hls-push.5centscdn')){
            $thumb = str_replace('.smil/playlist.m3u8', '_thumbs_0001.jpg', $hls_video_url);

            if (strlen(file_get_contents($thumb)))
                $video_image_url = $thumb;
        }

        $view = view('layouts.partials.playerEmbedStory',compact('count_embed_video','hls_video_url','style_video','videoformat','video_image_url'))->render();
        return $view;
    }
    public function post_embed_video_player_bc($attr = array())
    {
        if (isset($attr['bc_video_id'])) {
            $bc_video_id = $attr['bc_video_id'];
        }
        $BC_ACCOUNT_ID = '';
        $BC_PLAYER_ID = '';
        $bc_script = '<link rel="preconnect" href="https://players.brightcove.net/'.$BC_ACCOUNT_ID.'/'.$BC_PLAYER_ID.'_default/index.min.js" crossorigin><link rel="preload" href="https://players.brightcove.net/'.$BC_ACCOUNT_ID.'/'.$BC_PLAYER_ID.'_default/index.min.js" as="script"><link rel="prefetch" as="script" href="https://players.brightcove.net/'.$BC_ACCOUNT_ID.'/'.$BC_PLAYER_ID.'_default/index.min.js"/><script> var scriptElement=document.createElement("script"); scriptElement.type = "text/javascript"; scriptElement.setAttribute("rel", "script"); scriptElement.setAttribute("defer", "true"); scriptElement.src = "https://players.brightcove.net/'.$BC_ACCOUNT_ID.'/'.$BC_PLAYER_ID.'_default/index.min.js";document.body.appendChild(scriptElement);</script>';

        $embed_video = '<div style="max-width: 960px;"><video-js data-account="'.$BC_ACCOUNT_ID.'" data-player="'.$BC_PLAYER_ID.'" data-embed="default" controls="" data-video-id="'.$bc_video_id.'" data-playlist-id="" data-application-id="" class="vjs-fluid"></video-js></div>'.$bc_script;

        return $embed_video;
    }


    public function getAuthorsBySourceType($request){
        $sourceType = $request->sourceType;
        $Post = Post::find($request->postId);
        $selectedAuthors = $Post->authors()->pluck('authors.id')->toArray();
        $data = [];

        $authors = Author::where('type',$request->sourceType)->pluck('name','id');

        foreach ($authors as $id=>$val){
            $author = [
                'value' => $val,
                'selected' => (in_array($id,$selectedAuthors))?'yes':'no',
            ];
            $data[$id] = $author;

        }
        return $data;
    }
    public function getAuthorsBySourceTypeForLiveBlog($request){
        $sourceType = $request->sourceType;
        $data = [];
        $authors = Author::where('type',$request->sourceType)->pluck('name','id');
        foreach ($authors as $id=>$val) {
            $author = [
                'value' => $val,
                'selected' => 'no',
            ];
            $data[$id] = $author;
        }
        return $data;
    }
    public function getPostByIdsByPosts($posts,$type='array'){
        $array = [];
        foreach ($posts as $post)
        {

            $array[] = ($type == 'array')?$post['id']:$post->id;
        }
        return $array;
    }

    public function postBulkAction($ids,$action){
        if ($ids == null){
            return false;
        }
        foreach ($ids as $postId){
            $post = Post::find($postId);
            $post->is_published = $action;
            $post->save();
            $gService = new GeneralService();
            $gService->clear_cache_cloudflare('post',$post->id);
            $this->purgeRedisCache('postUpdate',$postId);
            $gService->cacheKeys('all');

            $this->return['msg'] = 'Post saved successfully.';
            Helper::AddActivity($post->id,'App\Models\Post',$this->return['msg']);

        }
    }


    /// Frontend / redis functions
    public function sortRedisCollection($collection, $request, $sortBy = 'id')
    {
        $sort = $request->input('sort', 'desc');
        $sortBy = $request->input('sortBy', $sortBy);
        if ($sort === 'asc') {
            $collection = $collection->sortBy([
                fn($a, $b) => $a[$sortBy] <=> $b[$sortBy]
            ]);
        } else if ($sort === 'desc') {
            $collection = $collection->sortBy([
                fn($a, $b) => $b[$sortBy] <=> $a[$sortBy]
            ]);
        }
        return $collection;
    }

    // Function to cache the latest Post Ids
    public function cacheLatestPostIds($limit=false){
        $redisKey = 'latestPostIds';
        $ids = Post::where([
            'is_published' => 1,
        ])->where('status','!=',0)->orderBy('posted_at','desc');
        if ($limit){
            $ids->limit($limit);
        }
        $ids = $ids->pluck('id','posted_at');

        foreach ($ids as $key=>$val){
            Redis::ZADD($redisKey,strtotime($key),$val);
        }

    }
    // Function to return Posts Array using above Cache
    public function postsByLatest($limit=false,$exceptId=false,$page=1){
        $offset = ($page - 1) * $limit;

        $sortedPostIds = Redis::zrevrange('latestPostIds', $offset, $offset + $limit - 1);
        if (!$sortedPostIds){
            $this->cacheLatestPostIds();
            $sortedPostIds = Redis::zrevrange('latestPostIds', $offset, $offset + $limit - 1);
        }
        $posts = [];
        if ($exceptId){
            if (isset($sortedPostIds[array_search($exceptId,$sortedPostIds)])){
                unset($sortedPostIds[array_search($exceptId,$sortedPostIds)]);
            }
        }
        foreach ($sortedPostIds as $postId) {
            $post = $this->getRedisPostByID($postId);
            $posts[] = $post;
        }
        return $posts;


    }

    // Function to cache popular Post Ids
    public function CacheMostPopularPosts(){
        $startOfWeek = Carbon::now()->startOfWeek();
        $ids = PostView::where('week_start', $startOfWeek)->orderBy('views','desc')->limit(5)->get();
        $redisKey = 'mostPopularPosts';
        foreach ($ids as $id){
            Redis::ZADD($redisKey,$id->views,$id->post_id);
        }

    }
    // Function to return Posts Array using above Cache
    public function mostPopularPosts($order='desc',$limit=false,$exceptId=false,$page=1){
        $offset = ($page - 1) * $limit;
        $start = 0;
        $stop = -1;
        $sortedPostIds = Redis::zrevrange('mostPopularPosts', $start, $stop,'WITHSCORES');
        if (!$sortedPostIds){
            $this->CacheMostPopularPosts();
            $sortedPostIds = Redis::zrevrange('mostPopularPosts', $start, $stop,'WITHSCORES');
        }//dd($sortedPostIds);
        $posts = [];
        if ($exceptId){
            if (isset($sortedPostIds[array_search($exceptId,$sortedPostIds)])){
                unset($sortedPostIds[array_search($exceptId,$sortedPostIds)]);
            }
        }
        foreach ($sortedPostIds as $key => $postId) {
            $post = $this->getRedisPostByID($key);
            $posts[] = $post;
        }
        return ['posts'=>$posts];


    }

    // Parse Post from redis, convert arrays to obj
    public function parsePost($post){
        // Converting relationships from array to objects

        if (property_exists($post,'main_category')){
            $post->MainCategory = (object) $post->main_category;
        }

        // Related Posts
        $related_posts = [];
        if (property_exists($post,'related_posts')) {
            if (count($post->related_posts)) {
                foreach ($post->related_posts as $related_post) {
                    $related_post[] = (object)$related_post;
                }
            }
        }
        $post->relatedPosts = $related_posts;
        // Tags
        $tags = [];
        if (property_exists($post,'tags')) {
            if (count($post->tags)) {
                foreach ($post->tags as $tag) {
                    $tags[] = (object)$tag;
                }
            }
        }
        $post->tags = $tags;
//        // Authors
//        $authors = [];
//        if (property_exists($post,'authors')) {
//            if (count($post->authors)) {
//                foreach ($post->authors as $author) {
//                    $authors[] = (object)$author;
//                }
//            }
//        }
//        $post->authors = $authors;

        // Meta
        $metas = [];
        if (property_exists($post,'meta')) {
            if (count($post->meta)) {
                foreach ($post->meta as $meta) {
                    $metas[] = (object)$meta;
                }
            }
        }
        $post->meta = $metas;

        // Categories
        $categories = [];
        if (property_exists($post,'categories')) {
            if (count($post->categories)) {
                foreach ($post->categories as $category) {
                    $categories[] = (object)$category;
                }
            }
        }
        $post->categories = $categories;

        // Template
        if (property_exists($post,'template')) {
            $post->template = (object)$post->template;
        }
        // User
        if (property_exists($post,'template')) {
            $post->user = (object)$post->user;
        }
        return $post;
    }

    // Accept Single id and return single post
    // Get post from redis collection || set post into redis collection from db
    public function getRedisPostByID($id){
        $postExists = Redis::exists('post:'.$id);
        if ($postExists) {
            $post = Redis::get('post:'.$id);
            $post = json_decode($post, true);
            $post = (object) $post;
            return  $this->parsePost($post);
        } else {
            $post = Post::where('id',$id)->where('is_published','1')->where('posts.status','!=','0')->with('user','template','categories','meta','tags','MainCategory','relatedPosts')->first();
            if ($post) {
                Redis::setex('post:'.$id, config('settings.cacheExpiry'), $post);
                return  $post;
            } else {
                return false;
            }
        }

    }

    // Accept Ids array and return posts array
    // Get posts from redis collection || set posts into redis collection from db
    public function getRedisPostsByID($ids): array
    {

        $posts = [];
        foreach ($ids as $id){
            $postExists = Redis::exists('post:'.$id);
            if ($postExists) {
                $post = Redis::get('post:'.$id);
                $post = json_decode($post, true);
                $post = (object) $post;
                $posts[] = $this->parsePost($post);
            } else {
                $post = Post::where('id',$id)->where('is_published','1')->where('posts.status','!=','0')->with('user','template','categories','meta','authors','tags','MainCategory','relatedPosts')->first();

                if ($post) {
                    Redis::setex('post:'.$id, config('settings.cacheExpiry'), $post);
                    $posts[] = $post;
                }
            }

        }
        return $posts;
    }

    // Cache per category Post ids in redis collection ie. postIdsByCatId{catID}
    public function postIdsByCat($catId,$isSubCat=false): void
    {
        if (!$isSubCat){
            \DB::enableQueryLog();
            $redisKey = 'postIdsByCatId'.$catId;
            $ids = Post::select('id','posted_at')
                ->where('category_id',$catId)
                ->where('is_published' , 1)
                ->where('status','!=',0)
                ->orderBy('posted_at','desc')->get();
               // ->pluck('id','posted_at');

        }else{
            $redisKey = 'postIdsByCatId'.$isSubCat;
//            $ids = CategoryPost::where('category_id',$isSubCat)->pluck('post_id');
            $ids = Category::find($isSubCat)->subCatPosts()
                ->where('posts.is_published' ,1)
                ->where('posts.status','!=',0)
                ->orderBy('posts.posted_at','desc')->get();
//                ->pluck('posts.id','posts.posted_at');


        }


        foreach ($ids as $post){

            Redis::ZADD($redisKey,strtotime($post->posted_at),$post->id);
        }
    }

    // Return post array by using above cache collection
    public function postsByCatId($type, $catId,$order='desc',$limit=10,$exceptId=false,$page=1,$isSubCat=false){

        $offset = ($page - 1) * $limit;
        if ($isSubCat){
            $sortedPostIds = Redis::zrevrange('postIdsByCatId'.$isSubCat, $offset, $offset + $limit - 1);
        }else{
            $sortedPostIds = Redis::zrevrange('postIdsByCatId'.$catId, $offset, $offset + $limit - 1);
        }


        if (!$sortedPostIds){

            $this->postIdsByCat($catId,$isSubCat);
            if ($isSubCat){
                $sortedPostIds = Redis::zrevrange('postIdsByCatId'.$isSubCat, $offset, $offset + $limit - 1);

            }else{
                $sortedPostIds = Redis::zrevrange('postIdsByCatId'.$catId, $offset, $offset + $limit - 1);
            }
        }

        $posts = [];


        if ($exceptId){
            if (isset($sortedPostIds[array_search($exceptId,$sortedPostIds)])){
                unset($sortedPostIds[array_search($exceptId,$sortedPostIds)]);
            }
        }
        foreach ($sortedPostIds as $postId) {
            $post = $this->getRedisPostByID($postId);

            if ($post != false){
                $posts[] = $post;
            }
        }

        return $posts;

    }

    // Return next and prev post from given Main Category from Redis
    public function getNextPrevPost($post): array
    {

        if (isset($post->MainCategory)){
            $catId = $post->MainCategory->id;
            $offset = 0;
            $limit = 1;
//            $posts = Redis::zrevrangebyscore('postIdsByCatId'.$catId, '(' . $post->id, '-inf', 'LIMIT', 0, 1);
            $postsIds =   Redis::zrange('postIdsByCatId'.$catId, 0, -1, ['withscores' => false]);
            if (!$postsIds){
                $this->postIdsByCat($catId);
                $postsIds =   Redis::zrange('postIdsByCatId'.$catId, 0, -1, ['withscores' => false]);
            }

        }
        $nextPost = false;
        $prevPost = false;
        if (isset($postsIds[array_search($post->id,$postsIds) + 1])){
            $nextPost = $this->getRedisPostByID($postsIds[array_search($post->id,$postsIds) + 1]);
        }
        if (isset($postsIds[array_search($post->id,$postsIds) - 1])){
            $prevPost = $this->getRedisPostByID($postsIds[array_search($post->id,$postsIds) - 1]);
        }
        return [
            'next' => $nextPost,
            'prev' => $prevPost,
        ];


    }

    // Accept Author obj, cache posts by author
    public function cacheAuthorPostIds($author){
        $authorId = $author->id;
        if (!$author){ return false; }
        $redisKey = 'postIdsByAuthorId'.$authorId;
        $ids = $author->posts()->where('posts.is_published','1')->where('posts.status','!=',0)->pluck('posts.id','posts.posted_at');
        foreach ($ids as $key=>$val){
            Redis::ZADD($redisKey,strtotime($key),$val);
        }
    }

    // Return posts array using above cache collection with author obj
    public function postsByAuthor($request,$type, $author,$order='desc',$limit=false,$exceptId=false,$page=1){
        $offset = ($page - 1) * $limit;
        $author = Author::where($author)->first();
        $authorId = $author->id;
        $sortedPostIds = Redis::zrevrange('postIdsByAuthorId'.$authorId, $offset, $offset + $limit - 1);
        if (!$sortedPostIds){
            $this->cacheAuthorPostIds($author);
            $sortedPostIds = Redis::zrevrange('postIdsByAuthorId'.$authorId, $offset, $offset + $limit - 1);
        }
        $posts = [];
        if ($exceptId){
            if (isset($sortedPostIds[array_search($exceptId,$sortedPostIds)])){
                unset($sortedPostIds[array_search($exceptId,$sortedPostIds)]);
            }
        }
        foreach ($sortedPostIds as $postId) {
            $post = $this->getRedisPostByID($postId);
            $posts[] = $post;
        }
        return ['posts'=>$posts,'author'=>$author];


    }

    // Cache Posts ids by tag
    public function cacheTagPostIds($tag){
        $tagId = $tag->id;
        if (!$tag){ return false; }
        $redisKey = 'postIdsByTagId'.$tagId;
        $ids = $tag->posts()->where('posts.is_published','1')->where('posts.status','!=',0)->pluck('posts.id','posts.posted_at');
        foreach ($ids as $key=>$val){
            Redis::ZADD($redisKey,strtotime($key),$val);
        }
    }

    // return post array by using above collection with tag obj
    public function postsByTag($request,$type, $tag,$order='desc',$limit=false,$exceptId=false,$page=1){
        $offset = ($page - 1) * $limit;
        $tag = Tag::where($tag)->first();

        $tagId = $tag->id;
        $sortedPostIds = Redis::zrevrange('postIdsByTagId'.$tagId, $offset, $offset + $limit - 1);
        if (!$sortedPostIds){
            $this->cacheTagPostIds($tag);
            $sortedPostIds = Redis::zrevrange('postIdsByTagId'.$tagId, $offset, $offset + $limit - 1);
        }
        $posts = [];
        if ($exceptId){
            if (isset($sortedPostIds[array_search($exceptId,$sortedPostIds)])){
                unset($sortedPostIds[array_search($exceptId,$sortedPostIds)]);
            }
        }
        foreach ($sortedPostIds as $postId) {
            $post = $this->getRedisPostByID($postId);
            $posts[] = $post;
        }
        return ['posts'=>$posts,'tag'=>$tag];


    }

    public function getCatFromSlug($slug){
        $cat = Category::where('slug',$slug)->first();
        return ($cat) ? $cat : false;
    }
    public function getCatFromId($id){
        $cat = Category::where('id',$id)->first();
        return ($cat) ? $cat : false;
    }

    public function getSubCat($mainCate,$subCat){
        if (!$mainCate){ return  false; }
        $cat = Category::where('parent_id',$mainCate->id)->where('slug',$subCat)->first();
        return ($cat) ? $cat : false;
    }
    public function getRandomPost($count,$excludingIds=[]): array
    {
        $PostIds = Post::whereNotIn('id',$excludingIds)
            ->where('posts.is_published','1')
            ->where('posts.status','!=',0)
            ->orderBy('posted_at','desc')
            ->limit($count)
            ->pluck('id');
        return $this->getRedisPostsByID($PostIds);

    }

    public function purgeRedisCache($action,$id=false): void
    {
        if ($action == 'postUpdate'){
            Redis::del('post:'.$id);
            $post = Post::where('id',$id)->where('is_published','1')->where('posts.status','!=','0')->with('user','template','categories','meta','tags','MainCategory','relatedPosts')->first();
            if ($post) {
                Redis::setex('post:'.$id, config('settings.cacheExpiry'), $post);
            }
            $categories = Category::all();
            foreach ($categories as $category){
                Redis::del('postIdsByCatId'.$category->id);
            }
//            $authors = Author::all();
//            foreach ($authors as $author){
//                Redis::del('postIdsByAuthorId'.$author->id);
//            }
            Redis::del('latestPostIds');
            Redis::del('mostPopularPosts');
            Cache::forget('sidebar');
            Cache::forget('homePage');
            Cache::forget('ContentPositions');




        }
        if ($action == 'onlyPostChange'){
            Redis::del('post:'.$id);
            $post = Post::where('id',$id)->where('is_published','1')->where('posts.status','!=','0')->with('user','template','categories','meta','tags','MainCategory','relatedPosts')->first();
            if ($post) {
                Redis::setex('post:'.$id, config('settings.cacheExpiry'), $post);
            }
        }

        if ($action == 'cfUpdate'){}
    }


    public function cacheKeys($type='all'){
        if ($type == 'categories' || $type == 'all'){
            $categories = Category::all();
            foreach ($categories as $category){
                $isSubCat = false;
                if ($category->parent_id != 0 && $category->parent_id != null){
                    $isSubCat = true;
                }
                $this->postIdsByCat($category->id,$isSubCat);
            }
        }
        if ($type == 'authors' || $type == 'all'){
            $authors = Author::all();
            foreach ($authors as $author){
                $this->cacheAuthorPostIds($author);
            }
        }

    }
}
