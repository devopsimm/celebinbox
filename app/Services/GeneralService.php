<?php

namespace App\Services;

use App\Http\Helpers\General\Helper;
use App\Models\Category;
use App\Models\ContentPosition;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Carbon\Carbon;
use DOMDocument;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

use JetBrains\PhpStorm\ArrayShape;

class GeneralService
{

    private PostService $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }
    public function manageAttachment($imageData)
    {

        if (!is_dir("uploadfiles/" . $imageData['folder_name'])) {
            mkdir("uploadfiles/" . $imageData['folder_name'], 0777, true);
        }
        if ($file = $imageData['data']->file($imageData['request_name'])) {
            $name = $imageData['file_name'] . '-' . time() . '.' . $file->clientExtension();
            $file->move('uploadfiles/' . $imageData['folder_name'], $name);
            $imageData['data']->request->add([$imageData['request_name_new'] => "uploadfiles/" . $imageData['folder_name'] . '/' . $name]);
        }
        if ($imageData['returnType'] == 'request') {
            return $imageData['data'];
        } else {
            return "uploadfiles/" . $imageData['folder_name'] . '/' . $name;
        }
    }
    public function textToSlug($text)
    {
        $slug = str_replace(" ", "-", $text);
        $slug = strtolower($slug);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $slug);

    }
    public function nameToSlug($request, $name)
    {

        $slug = str_replace(" ", "-", $request->$name);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);

        $request->request->add(['slug' => $slug]);
        return $request;
    }

    public function removePreviousImg($img)
    {
        if (file_exists($img)) {
            unlink($img);
        }
    }

    public function verifyPostSlug($slug,$post){
        unset($slug[0]);
//        dd($post->slug .'--------------------'. implode('-',$slug));
        if ($post->slug == implode('-',$slug)){
            return true;
        }
        return false;
    }

    public function verifySlug($model, $slug, $exceptId = null)
    {
        $get = $model::where('slug', $slug);
        if ($exceptId != null) {
            $get = $get->where('id', '!=', $exceptId);
        }
        $get = $get->count();
        if ($get == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function removeSpecialChar($str)
    {
        $res = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $str);
        return $res;
    }

    public function handleException($e,$route=false)
    {
        if ($route){
            return redirect()->route($route)->with('error','Something went wrong, Please try again later');
        }
        return null;
    }

    public function getCategory($slug): \Illuminate\Database\Eloquent\Model|bool|Category
    {
        $cat =  Category::where('slug',$slug)->first();
        return $cat ? $cat : false;
    }

    public function uploadImgAi($image, $path,$thumbnails=false,$fName=false)
    {

        $dirPath = '/home/1443902.cloudwaysapps.com/wmwzycmxbm/public_html/storage/app/public/';
//       $dirPath = env('APP_ROOT');
//

        $date = Carbon::now()->format('y-m-d');
        if (!$fName){
            $fileNameString = time() . rand(0, 9999);
        }else{
            $fileNameString = '';
        }
        $imageContent = file_get_contents($image);
        $extenstion = explode('.',$image);
        $extenstion = $extenstion[count($extenstion)-1];
        $fileName = $fileNameString . '.' . $extenstion;
        $path = $path . '/'.$date.'/';

        if(!Storage::exists('public/' .$path.'/')){
            mkdir($dirPath.$path, 0777,true);
            chmod($dirPath.$path,0777);
        }

//        $image->storeAs('public/' . $path, $fileName);
        file_put_contents($dirPath . $path . $fileName, $imageContent);
         $mainImg = 'storage/' . $path . $fileName;


        if ($thumbnails == 'postThumbnails'){

            if(!file_exists($dirPath .$path.'/thumbs/')){
                mkdir($dirPath.$path.'/thumbs/', 0777);
                chmod($dirPath.$path.'/thumbs/',0777);

            }
            $sizes = config('settings.thumbnails.'.$thumbnails);
            foreach ($sizes as $size){
                //$thumb_name =$fileNameString.'.'.$image->getClientOriginalExtension();
                $thumb_name =$fileNameString.'.webp';
                $thumb = Image::make($mainImg)->encode('webp', 90)->resize($size[0],$size[1]);
                $folder = implode('X',$size);
                if(!Storage::exists('public/' .$path.'thumbs/'.$folder.'/')){
                    // Storage::makeDirectory('public/' .$path.'thumbs/'.$folder.'/');
                    mkdir($dirPath.$path.'/thumbs/'.$folder.'/', 0777);
                    chmod($dirPath.$path.'/thumbs/'.$folder.'/',0777);
                }
                $thumb->save(storage_path('app/'.'public/'.$path.'thumbs/'.$folder.'/').$thumb_name);
            }
        }


        return $path.'thumbs/'.'700X390'.'/'.$thumb_name;
    }


    public function uploadImg($image, $path,$thumbnails=false,$fName=false)
    {

//        $dirPath = '/home/1443902.cloudwaysapps.com/xevxpmjdfs/public_html/storage/app/public/';
        $dirPath = env('APP_ROOT');
        $dirPath = '/home/1443902.cloudwaysapps.com/wmwzycmxbm/public_html/storage/app/public/';

        $date = Carbon::now()->format('y-m-d');
        if (!$fName){
            $fileNameString = time() . rand(0, 9999);
        }else{
            $fileNameString = '';
        }

        $fileName = $fileNameString . '.' . $image->getClientOriginalExtension();
        $path = $path . '/'.$date.'/';

        if(!Storage::exists('public/' .$path.'/')){
            mkdir($dirPath.$path, 0777,true);
            chmod($dirPath.$path,0777);
        }
//        dd($dirPath.$path);
//        chmod($dirPath.$path,0777);
        $image->storeAs('public/' . $path, $fileName);
        $mainImg = 'storage/' . $path . $fileName;


        if ($thumbnails == 'postThumbnails'){

            if(!file_exists($dirPath .$path.'/thumbs/')){
                mkdir($dirPath.$path.'/thumbs/', 0777);
                chmod($dirPath.$path.'/thumbs/',0777);

            }
            $sizes = config('settings.thumbnails.'.$thumbnails);
            foreach ($sizes as $size){
                //$thumb_name =$fileNameString.'.'.$image->getClientOriginalExtension();
                $thumb_name =$fileNameString.'.webp';
                $thumb = Image::make($mainImg)->encode('webp', 90)->resize($size[0],$size[1]);
                $folder = implode('X',$size);
                if(!Storage::exists('public/' .$path.'thumbs/'.$folder.'/')){
                    // Storage::makeDirectory('public/' .$path.'thumbs/'.$folder.'/');
                    mkdir($dirPath.$path.'/thumbs/'.$folder.'/', 0777);
                    chmod($dirPath.$path.'/thumbs/'.$folder.'/',0777);
                }
                $thumb->save(storage_path('app/'.'public/'.$path.'thumbs/'.$folder.'/').$thumb_name);
            }
        }

        return $mainImg;
    }


    public function createThumb($file,$thumb){
//        try {
//
        $dirPath = '/home/1443902.cloudwaysapps.com/wmwzycmxbm/public_html/storage/app/public/';

        $fileEle = explode('/',$file);
        $fileName = $fileEle[count($fileEle)-1];
        unset($fileEle[count($fileEle)-1]);
        unset($fileEle[0]);
        $thumbPath = implode('/',$fileEle).'/thumbs/'.$thumb.'/';
        $thumbPathForSave ='public/'. $thumbPath;
        $sizes = explode('X',$thumb);
        //  echo $thumbPathForSave;

        if(!Storage::exists($thumbPathForSave)){
//            if (!file_exists($dirPath.$thumbPath)){
            mkdir($dirPath.$thumbPath, 0777,true);
            chmod($dirPath.$thumbPath,0777);
//            }

        }
        $thumb = Image::make($file)->encode('jpg', 90)->resize($sizes[0],$sizes[1]);
        $fileNameWithOutExt = explode('.',$fileName);
        unset($fileNameWithOutExt[count(explode('.',$fileName))-1]);
        $fileNameWithOutExt = $fileNameWithOutExt[0];
        //dd($thumbPathForSave);
        $thumb->save(storage_path('app/'.$thumbPathForSave).$fileNameWithOutExt.'.jpg');

        return 'storage/'.$thumbPath.$fileNameWithOutExt.'.jpg';
//        }catch (\Exception $exception){
//
//           // Self::errorHandling($exception,$file);
//            return  url(config('settings.placeholderImg'));
//
//        }
    }


    public function processImagesInHtml(string $html,string $altText, string $storageDir = 'storage/app/public/posts/'): string
    {
        // Make sure directory exists
        $dirPath = '/home/1443902.cloudwaysapps.com/wmwzycmxbm/public_html/';

        // Ensure the target directory exists
        if (!file_exists($dirPath . $storageDir)) {
            mkdir($dirPath . $storageDir, 0755, true);
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        // Use a wrapper to avoid DOMDocument adding html/body tags
        $isFullHtml = (stripos($html, '<html') !== false);
        if (!$isFullHtml) {
            $html = '<div>' . $html . '</div>';
        }

        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        $imageCount = $images->length;
        $replacements = [];

        for ($i = 0; $i < $imageCount; $i++) {
            $img = $images->item($i);
            if (!$img) continue;
            $originalSrc = $img->getAttribute('src');

            // Skip if the image is already on our domain or doesn't have a source
            if (empty($originalSrc) || Str::startsWith($originalSrc, url('/'))) {
                continue;
            }

            try {
                // Clean up the URL and get extension
                $cleanUrl = str_replace(' ', '%20', $originalSrc);
                $extension = pathinfo(parse_url($cleanUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (empty($extension)) {
                    $extension = 'jpg';
                }

                // Create a unique filename
                $fileNameString = time() . rand(0, 9999);
                $filename = $fileNameString . '.' . $extension;
                $fullPath = $storageDir . $filename;
                $viewPath = 'storage/posts/'.$filename;

                // Add a user agent to avoid being blocked
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                ])->timeout(10)->get($cleanUrl);

                if ($response->successful()) {
                    // Get the image content
                    $imageContent = $response->body();

                    // Check if we actually got an image
                    if (strlen($imageContent) > 0) {
                        // Make sure directory exists again (just in case)
                        if (!file_exists($dirPath . $storageDir)) {
                            mkdir($dirPath . $storageDir, 0755, true);
                        }

                        // Full path for saving the file
                        $saveFilePath = $dirPath . $fullPath;

                        // Save the image
                        $result = file_put_contents($saveFilePath, $imageContent);

                        // Check if file was written successfully
                        if ($result !== false) {
                            // Create the new URL
                            $newUrl = url($viewPath);

                            // Add to replacements array
                            $replacements[] = [
                                'old' => $originalSrc,
                                'new' => $newUrl
                            ];

                            // Set the new source
                            $img->setAttribute('src', $newUrl);

                            $img->setAttribute('alt', $altText);


                            // Log success for debugging
                            \Log::info("Successfully downloaded and saved image: " . $originalSrc . " to " . $saveFilePath);
                        } else {
                            \Log::error("Failed to write image file: " . $saveFilePath . " - Check directory permissions");
                        }
                    } else {
                        \Log::error("Downloaded image is empty: " . $originalSrc);
                    }
                } else {
                    \Log::error("Failed to download image - Status code: " . $response->status() . " URL: " . $originalSrc);
                }
            } catch (Exception $e) {
                \Log::error("Failed to download image: " . $originalSrc . " Error: " . $e->getMessage());
            }
        }

        // Get the updated HTML
        $updatedHtml = $dom->saveHTML();

        // If we added a wrapper div, remove it now
        if (!$isFullHtml) {
            // Remove the wrapper div and any doctype/html/body tags that might have been added
            $updatedHtml = preg_replace('/<\!DOCTYPE.*?>/i', '', $updatedHtml);
            $updatedHtml = preg_replace('/<html.*?>(.*)<\/html>/is', '$1', $updatedHtml);
            $updatedHtml = preg_replace('/<body.*?>(.*)<\/body>/is', '$1', $updatedHtml);
            $updatedHtml = preg_replace('/<div>(.*)<\/div>/is', '$1', $updatedHtml);

            // Clean up any leading/trailing whitespace
            $updatedHtml = trim($updatedHtml);
        }

        // Return the updated HTML
        return $updatedHtml;
    }


    public function downloadImage(string $imageUrl, string $saveDir = 'storage/app/public/posts/featureImages/')
    {

        if (empty($imageUrl) || Str::startsWith($imageUrl, url('/'))) {
            \Log::info("Image Already on domain ");
           return  $imageUrl;
        }


        $basePath = '/home/1443902.cloudwaysapps.com/wmwzycmxbm/public_html/';
       // $basePath = env('APP_ROOT');
        $fullSaveDir = $basePath . $saveDir;
        try {
            $imageUrl = str_replace(' ', '%20', trim($imageUrl));
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($extension)) {
                $extension = 'jpg';
            }
            $filename = time() . '_' . rand(1000, 9999) . '.' . $extension;

            $fullPath = $fullSaveDir . $filename;
            $relativePath = $saveDir . $filename;

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ])->timeout(15)->get($imageUrl);

            if (!$response->successful()) {
                \Log::info("Image response not successful ");
                return config('settings.placeholderImgFull');
            }
            $imageContent = $response->body();
            if (empty($imageContent) || strlen($imageContent) < 100) {
                \Log::info("Image content not found");
                return config('settings.placeholderImgFull');
            }
            $saveResult = file_put_contents($fullPath, $imageContent);
            if ($saveResult === false) {
                \Log::info("Image cant save ");
                return config('settings.placeholderImgFull');
            }
            return str_replace('storage/app/public/', 'storage/', $relativePath);
        } catch (Exception $e) {
            \Log::info("catch ");
            return config('settings.placeholderImgFull');
        }
    }






    public function convertImgToNextGenImg($file,$nextGenFormat){
        $fileEle = explode('/',$file);



        $fileName = $fileEle[count($fileEle)-1];
        $fileNameEle = explode('.',$fileName);
        $ext = $fileNameEle[count($fileNameEle)-1];


        if ($ext == $nextGenFormat){
            return $file;
        }

        unset($fileNameEle[count($fileNameEle)-1]);
        $fileNameWithoutExt = implode('.',$fileNameEle);


        unset($fileEle[count($fileEle)-1]);
        $path = implode('/',$fileEle);
        if (file_exists($path.'/'.$fileNameWithoutExt.'.webp')){
            return $path.'/'.$fileNameWithoutExt.'.webp';
        }
//        if (!file_exists($path.'/'.$fileNameWithoutExt.$ext)){ return $file; }
        if (in_array($ext, config('settings.allowedExt'))){
            $file = $this->convertFile([
                'file'=>$file,
                'fileNameWithoutExt'=>$fileNameWithoutExt,
                'path'=>$path,
            ],$nextGenFormat);
        }

        return  $file;
    }

    public function convertFile($data,$type){
        $file = $data['file'];

        $fileNameWithOutExt = $data['fileNameWithoutExt'];
        $thumbPathForSave = $data['path'];
        $thumbPathForSave = str_replace('storage','public',$thumbPathForSave);

        $thumb = Image::make($file)->encode($type, 90);
        $thumb->save(storage_path('app/'.$thumbPathForSave).'/'.$fileNameWithOutExt.'.'.$type);
        return $data['path'].'/'.$fileNameWithOutExt.'.'.$type;
    }

    public function getModelIdsFromContentPosition($details): array
    {
        $ids = [];
        foreach ($details as $detail){
            if ($detail->model_id != null){
                $ids[] = $detail->model_id;
            }
        }
        return $ids;
    }

    public function cacheContentPositions(): void
    {
        $posts = Cache::remember('ContentPositions',config('settings.cacheExpiry'),fn() => ContentPosition::with('details')->get());
    }

    public function getPositionContent($req): array
    {

        $postService = new PostService();
        $contentPositions = Cache::get('ContentPositions');

        if ($contentPositions == null){
            $this->cacheContentPositions();
            $contentPositions = Cache::get('ContentPositions');
        }
        $data = [];

        foreach ($contentPositions as $contentPosition){
            if (in_array($contentPosition->key,$req)){
                $modalIds = [];

                if (count($contentPosition->details)){
                    $modalIds = $this->getModelIdsFromContentPosition($contentPosition->details);
                }
                $entities = $postService->getRedisPostsByID($modalIds);

                if (count($entities) != $contentPosition->slots ){
                        $entities = $this->addRandomPost($contentPosition->slots - count($entities),$entities);
                    }

                $data[$contentPosition->key] = $entities;
            }
        }
        $remain = $this->getRemainingRequiredPositions($req,$data);
        if (count($remain)){
            $data = $this->fillRemainingRequiredPositions($remain,$data);
        }
        return $data;
    }

    public function fillRemainingRequiredPositions($remain,$data){
        foreach ($remain as $key){
            $data[$key] = $this->addRandomPost(config('settings.contentPositions.'.$key.'.slots'),[]);
        }
        return $data;
    }

    public function getRemainingRequiredPositions($req,$data){
        $remaining = [];
        foreach ($req as $key){
            if (!isset($data[$key])){
                $remaining[] = $key;
            }
        }
        return $remaining;
    }

    public function getSideBarData(){
        $postService = new PostService();
        $sideCats = [];
        foreach (config('settings.catIdsForSideBar') as $key=>$val){
            $sideCats[$val['title']] = $postService->postsByCatId('redis',$key,'desc',$val['count']);
        }
        $cp =  $this->getPositionContent(['most_reads']);
        $mostReadPosts = $cp['most_reads'];
        return [
            'mostReadPosts'=>$mostReadPosts,
            'sideCats' => $sideCats

        ];
    }
    public function cacheSideBar(){

        Cache::remember('sidebar',config('settings.cacheExpiry'),fn() => $this->getSideBarData());
    }
    public function cacheHome($request): void
    {
        Cache::remember('homePage',config('settings.cacheExpiry'),fn() => $this->getHomePageData($request));
    }
    public function getHomePageData($request): array
    {
        $postService = new PostService();
        $getPositionContent = $this->getPositionContent(['home_banner']);
        $bannerPosts = $getPositionContent['home_banner'];

        $homeCats = [];
        foreach (config('settings.catIdsForHomePage') as $key=>$val){

            $homeCats[$val['title']] = $postService->postsByCatId('redis',$key,'desc',$val['count']);
        }
        return [
            'bannerPosts'=>$bannerPosts,
            'homeCats' => $homeCats

        ];

    }

    public function postMetaKeyWise($meta): array
    {
        $data = [];

        foreach ($meta as $m){
            $data[$m->key] = $m;
        }
        return $data;
    }

    public function cacheAllPosts(){
        $posts = Post::where('posts.status','!=','0')->with('user','template','categories','meta','tags','MainCategory','relatedPosts')->get();
        foreach ($posts as $post){
            Redis::set('post:'.$post->id,$post,'EX',config('settings.cacheExpiry'));
        }
    }


    public function addRandomPost($slot,$entities): array
    {
        $excludingIds = [];
        if (config($entities)){
            foreach ($entities as $entity){
                $excludingIds[] = $entity->id;
            }
        }
        $PostIds = Post::whereNotIn('id',$excludingIds)
            ->where('posts.is_published','1')
            ->where('posts.status','!=',0)
            ->orderBy('posted_at','desc')
            ->limit($slot)
            ->pluck('id');

        $posts = $this->postService->getRedisPostsByID($PostIds);

        return array_merge($entities,$posts);

    }

    public function checkIfDotInId($id){
        $ids = explode('.',$id);
        if (count($ids) == 2){
            return false;
        }
        return  true;
    }


    public function sendNewPostNotification($message,$url){

        $usersWithRole = User::role(['Admin','Post Editor'])->get();
        foreach ($usersWithRole as $user) {
            $user->notify(new NewPostNotification($message, $url));
        }
        return true;
    }

    public function saveDownloadedImgInDb($id,$img){
        $post = Post::find($id);
        if (!$post){ return false; }
        $post->featured_image = $img;
        $post->save();
    }

    public function createSiteMap($type = 'daily',$category=false,$month=false,$year=false)
    {
        if ($type == 'daily'){
            $categories = Category::where('type','2')->get();
            if (count($categories)){
                foreach ($categories as $category){
                    // \DB::enableQueryLog();
                    $posts = $category->publishedPostsToNow()->latest()->limit(200)->get();
                    // dd(\DB::getQueryLog());
                    if (count($posts)){
                        $view = view('sitemaps.categoryPosts',compact('posts','category'));
                        file_put_contents(public_path('site-maps/categories/'.$category->slug.'.xml'),$view);
                    }
                }
            }
            $brands = Brand::all();
            if (count($brands)){
                $view = view('sitemaps.brands',compact('brands'));
                file_put_contents(public_path('site-maps/brands.xml'),$view);
            }
            $productTypes = ProductType::all();
            if (count($productTypes)){
                foreach ($productTypes as $type){
                    $products = $type->publishProducts;//()->latest()->limit(200)->get();
                    if (count($products)){
                        $view = view('sitemaps.productType',compact('products'));
                        file_put_contents(public_path('site-maps/product-categories/'.$type->slug.'.xml'),$view);
                    }
                }
            }


        }

        if ($type == 'monthly'){
            $date = Carbon::now();
            $year = $date->format('Y');
            $month = $date->format('m');

            $domain = 'https://gadinsider.com';
            $categories = Category::where('parent_id','0')->orWhere('parent_id',null)->with('childCategories')->get();
            $view = view('sitemaps.main',compact('domain','categories'));
            file_put_contents(public_path('site-maps/sitemap.xml'),$view);

            $posts = Post::whereMonth('posted_at', Carbon::now()->month)->where('is_published','1')->get();
            if (count($posts)){
                $view = view('sitemaps.monthly',compact('posts'));
                file_put_contents(public_path('site-maps/'.$month.'-'.$year.'.xml'),$view);
            }
        }
        if ($type == 'main'){
            $date = Carbon::now();
            $year = $date->format('Y');
            $month = $date->format('m');

            $domain = 'https://gadinsider.com';
            $categories = Category::where('parent_id','0')->orWhere('parent_id',null)->with('childCategories')->get();
            $view = view('sitemaps.main',compact('domain','categories'));
            file_put_contents(public_path('site-maps/sitemap.xml'),$view);
        }


        if ($type == 'category'){

            $posts = $category->publishedPostsToNow()->latest()->get();
            if (count($posts)){
                //  $view = view('sitemaps.categoryPosts',compact('posts','category'));
                return response()->view('sitemaps.categoryPosts', [
                    'posts' => $posts,
                    'category' =>$category,
                ])->header('Content-Type', 'text/xml');
            }else{
                return false;
            }
        }


        if ($type == 'website'){
            $domain = 'https://gadinsider.com';
            $categories = Category::where('parent_id','0')->orWhere('parent_id',null)->with('childCategories')->get();
            return response()->view('sitemaps.main', [
                'domain' => $domain,
                'categories' => $categories,
            ])->header('Content-Type', 'text/xml');
        }
        if ($type == 'DynamicMonthly'){
            $posts = Post::whereMonth('posted_at', $month)->where('is_published','1')->get();
            if (count($posts)){
                return response()->view('sitemaps.monthly', [
                    'posts' => $posts,
                ])->header('Content-Type', 'text/xml');
            }
        }
        if ($type == 'latest'){
            $posts = Post::where('is_published','1')->orderBy('id','desc')->limit(200)->get();
            if (count($posts)){
                return response()->view('sitemaps.latest', [
                    'posts' => $posts,
                ])->header('Content-Type', 'text/xml');
            }
        }


    }


}


