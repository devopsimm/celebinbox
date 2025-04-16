<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\General\Helper;
use App\Models\Category;
use App\Models\CornTest;
use App\Models\Post;
use App\Services\GeneralService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class DashboardController extends Controller
{
    private $gService;

    public function __construct()
    {
        $this->gService = new GeneralService();
    }
    public function index(){

        return view('admin.dashboard');
    }

    public function templates($key){
        $data = false;
        $i = false;
        if (view()->exists('admin.layouts.templates.'.$key)){
            return view('admin.layouts.templates.'.$key,compact('data','i'));
        }
        return '';
    }
    public function tinyUpload(Request $request){
        $fileName= $request->file('file')->getClientOriginalName();
        $path=$request->file('file')->storeAs('uploads', $fileName, 'public');


        if ($file = $request->file('file')) {

            $memeType = $file->getMimeType();
            $path = "uploads";
            if(!is_dir($path)){
                if (!mkdir($path, 0777, true) && !is_dir($path)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                }
            }
            $name = rand(0,9999).$file->getClientOriginalName();
            $file->move($path, $name);
            return response()->json(['location'=>'/'.$path.'/'.$name]);
        }

        return false;
    }

    public function markNotificationUnRead(Request $request){
        $current_date_time = Carbon::now()->toDateTimeString();
        \DB::table('notifications')->where('id',$request->id)->update(['read_at'=>$current_date_time]);
        return $request->id;
    }
    public function notificationDeleteAll(){
        $user = auth()->user();
        $user->notifications()->delete();
        return redirect()->back();
    }
    public function notificationReadAll(){
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function test(){
        $categories = Category::where('type','2')->get();
        if (count($categories)){
            foreach ($categories as $category){
                $posts = $category->publishedPostsToNow()->latest()->limit(200)->get();
                foreach ($posts as $post){
                    if ($post->is_published != 1){
                        dd($post);
                    }
                }
            }
            dd('not found');
        }
    }





}
