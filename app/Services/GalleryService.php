<?php

namespace App\Services;

use App\Http\Helpers\General\Helper;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Services\GeneralService;

class GalleryService
{

    public array $specificationExcept = ['_token','_method', ];

    public array $return =  ['type'=>'success','msg' => 'Product saved successfully'];
    private $gService;
    public function __construct()
    {
        $this->gService = new GeneralService();
    }

    public function index(){
        return  Gallery::paginate();
    }

    public function formData($id=false): array
    {
        $gallery = new Gallery();
        $images = false;
        if ($id){
            $gallery = $gallery::find($id);
            if (!$gallery) { return  abort(404); }
            $images = $gallery->images;
        }
        return [
            'gallery'=>$gallery,
            'images' => $images,
        ];
    }
    public function show($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|Gallery|null
    {
        $gallery = Gallery::find($id);
        return $gallery;
    }

    public function save($request){
        try{
            $galleryImage = new GalleryImage();
            $gallery = Gallery::create(['title'=>$request->title,'status'=>'1']);
            $galleryId = $gallery->id;
            foreach ($request->imagegallery as $key=>$val){
               $altKey = 'gallaryimagename'.$key+1;
               $orderKey = 'order'.$key+1;
               $data = [
                   'gallery_id' => $galleryId,
                   'image'=> $this->gService->uploadImg($val,'gallery'),
                   'sequence'=>$request->$orderKey,
                   'title' => $request->$altKey,
                   'description'=>'',
                   'status'=>1
               ];
               $galleryImage::create($data);
            }
            $this->return['msg'] = 'Gallery Created';
        }catch (\Exception $exception){
            $helper = new Helper();
            $helper::errorHandling($exception,$request);
            $this->return['type'] = 'error';
            $this->return['msg'] = 'Something went wrong, Please try again later';
        }

        return $this->return;


    }

    public function update($request,$gallery){

        try{
        $galleryImage = new GalleryImage();
        $this->updatePreviousImages($request);


        $gallery->title = $request->title;
        $gallery->save();
        $galleryId = $gallery->id;
        $requestArray = $request->all();

        if ($request->imagegallery != null && count($request->imagegallery) != 0) {
            foreach ($request->imagegallery as $key => $val) {
                $altKey = 'gallaryimagename' . $key + 1;
                $orderKey = 'order' . $key + 1;
                if (isset($requestArray[$orderKey])) {
                    $data = [
                        'gallery_id' => $galleryId,
                        'image' => $this->gService->uploadImg($val, 'gallery'),
                        'sequence' => $request->$orderKey,
                        'title' => $request->$altKey,
                        'description' => '',
                        'status' => 1
                    ];
                    $galleryImage::create($data);
                }
//
            }
        }
        $this->return['msg'] = 'Gallery Updated';
        }catch (\Exception $exception){
            $helper = new Helper();
            $helper::errorHandling($exception,$request);
            $this->return['type'] = 'error';
            $this->return['msg'] = 'Something went wrong, Please try again later';
        }

        return $this->return;
    }
    public function updatePreviousImages($request){
        $galleryImage = new GalleryImage();
        $ids = array_filter($request->id, function ($id){ return $id != null; });
        if (count($ids)){
            foreach ($ids as $id){
              $data = [
                  'title' => $request->gallaryimagename[$id],
                  'sequence'=>$request->order[$id]
              ];
              $galleryImage::where('id',$id)->update($data);
            }
        }
    }


    public function delete($id){
        $gallery = new Gallery();
        $gallery = $gallery::find($id);
        if (!$gallery) { return  abort(404); }
        foreach ($gallery->images as $img){
            $this->gService->removePreviousImg($img);
            $img->delete();
        }
        $gallery->delete();
        $this->return['msg'] = 'Gallery removed';
        return  $this->return;

    }

    public function deleteImgAjax($request): void
    {
        $this->gService->removePreviousImg('/storage/gallery'.$request->image_name);
        GalleryImage::where('id',$request->image_id)->delete();
    }

    public function getHtml($id){
        $gallery = Gallery::find($id);
        if ($gallery){
            return view('website.partials.galleryHtml',compact('gallery'))->render();
        }
        return '';
    }

}
