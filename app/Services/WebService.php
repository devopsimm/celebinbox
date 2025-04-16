<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class WebService
{

    public array $return =  ['type'=>'success','msg' => ''];

    public function __construct()
    {
        $this->gService = new GeneralService();
    }

    public function homePageData($request){
        Cache::forget('homePage');
        $data = Cache::get('homePage');
//         $data = $this->gService->getHomePageData($request);
//         dd($data['homeCats']);
        if ($data == null){
            $data = $this->gService->cacheHome($request);
            $data = Cache::get('homePage');
        }
        return $data;
    }

}
