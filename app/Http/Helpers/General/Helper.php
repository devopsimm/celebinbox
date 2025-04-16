<?php

namespace App\Http\Helpers\General;


use App\Models\Activity;
use App\Models\Tag;
use App\Services\GeneralService;
use App\Services\PostService;
use App\Services\WebService;
use Carbon\Carbon;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Self_;
use function PHPUnit\Framework\fileExists;

class Helper{

    /**
     * This function will add ellipsis in a string after given Limit
     * @param $str
     * @param $limit
     * @param string $end
     * @return string
     */
    public static function ellipsis($str, $limit=null, $end='...',$stripHTML=false){
        if(!$limit)
            $limit = config('settings.text_limit');

        if($stripHTML)
            $str = strip_tags($str);

        return \Illuminate\Support\Str::limit($str, $limit = $limit, $end = $end);
    }

    public static function errorHandling($exception,$request){
        //            $data = ['message' => $exception->getMessage()];
//            $mail = Mail::to(config('settings.map.dev_email'))->send(new TestEmail($data));
    }

    public static function textToSlug($text){
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
    public static function nameToUrl($name){
        $url = strtolower($name);
        $url = str_replace(' ','-',$url);
        $url = preg_replace('/[^A-Za-z0-9\-]/', '', $url);
        return $url;
    }
    public static function getFileUrl($file,$modal=false,$table=false,$thumb=false,$nextGenFormat='jpg'){

//        try {
        $gService = new GeneralService();
        if ($file == null){
            return '';
        }
        $newFolder = '';
        if ($modal != false){
            $newFolder = Carbon::parse($modal->created_at)->format('Y-m-d').'/';


        }


        if ($thumb != false){
                $fileEle = explode('/',$file);
                $fileName = $fileEle[count($fileEle)-1];
                $nameWithOutExt = explode('.',$fileName);
                unset($nameWithOutExt[count($nameWithOutExt)-1]);
                $nameWithOutExt = $nameWithOutExt[0];
                $ext = '.jpg';

                unset($fileEle[count($fileEle)-1]);
                $thumbPath = implode('/',$fileEle).'/thumbs/'.$thumb.'/';



                if (file_exists($thumbPath.$nameWithOutExt.$ext)){

                    return url($thumbPath.$nameWithOutExt.$ext);
                }else{

                    if (!file_exists($file)){return  url(config('settings.placeholderImg')); }
                    $thumb = $gService->createThumb($file,$thumb);
                    return  url($thumb);
                }
            }

//            $file = $gService->convertImgToNextGenImg($file,$nextGenFormat);

        return url($file);



//        }catch (\Exception $exception){
////            dd($modal->id);
//            //  Self::errorHandling($exception,$file);
//            return  url(config('settings.placeholderImg'));
//
//        }


    }

    public static function convertDateFormat($date,$convertTo){
        $date = Carbon::parse($date);

        if($convertTo == '24'){
            return $date->format('Y-m-d H:i:s');
        }
        return $date->format('Y-m-d h:i:s A');
//        return $date->format('m-d-Y h:m:s A');
    }

    public static function cleanText($text){
        return strip_tags($text);
    }

    public static function makeArray($val){
        if (is_array($val)){
            return $val;
        }
        return [$val];
    }

    public static function isJson($string) {
        if (is_object(json_decode($string))){
            return true;
        }
        return  false;
    }

    public static function removeHtmlTags($string){

        $withoutImgTags = preg_replace('/<img[^>]*>/', '', $string);
        $cleanedString = strip_tags($withoutImgTags);

        return $cleanedString;
    }

    public static function AddActivity($modelId,$modelType,$msg){
        Activity::create(
            [
                'user_id' => auth()->id(),
                'activity'=>$msg.' : '.request()->ip(),
                'model_type' => $modelType,
                'model_id' => $modelId,
            ]
        );
    }

    public static function isAbsoluteUrl($url) {
        $parsedUrl = parse_url($url);
        return isset($parsedUrl['scheme']) && isset($parsedUrl['host']);
    }

    public static function getFeaturedImg($post,$thumb=false){
        $gService = new GeneralService();
        $img = $post['post']->featured_image;
        if ($img == null){
            return  null;
        }



        $isAbsolute = Helper::isAbsoluteUrl($img);
        if ($post['post']->id == '5646') {
            // dd($img);
        }

        if ($isAbsolute){
            $img = $gService->downloadImage($img);
            $gService->saveDownloadedImgInDb($post['post']->id, $img);
            $pService = new PostService();
            $pService->purgeRedisCache('onlyPostChange',$post['post']->id);


            return url($img);
        }else{
           ;
           // dd($img);
            return Helper::getFileUrl($img,$post['post'],'post',$thumb);
        }
    }



    public static function displayRightSideBar(){
        $gService = new GeneralService();
//        Cache::forget('sidebar');
        $data = Cache::get('sidebar');
        if ($data == null){
            $gService->cacheSideBar();
            $data = Cache::get('sidebar');
        }

        return view('layouts.partials.web.rightSideBar')->with($data);
    }

}
