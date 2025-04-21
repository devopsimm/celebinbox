<?php

namespace App\Http\Controllers;

use App\Http\Helpers\General\Helper;
use App\Models\Feed;
use App\Models\Post;
use App\Services\GeneralService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedsController extends Controller
{
    //
    public string|PostService $postService = '';
    public string|GeneralService $gService = '';

    public function __construct()
    {
        $this->gService = new GeneralService();
        $this->postService = new PostService();
    }

    public function getFeed(Request $request){
        \Log::info('inside feed');


        $data = $request->json()->all();
//        \Log::info($data);
        $data = json_decode(json_encode($data));
        if (!isset($data->feed)){
            return false;
        }
        // dd($data);
        //    \Log::info($data);
        $feed = $data->feed;
        $feedSlug = Helper::textToSlug($feed->name);
        $feedDb = Feed::where('slug',$feedSlug)->first();
        if (!$feedDb){
            $feedDb = Feed::create([
                'slug' => $feedSlug,
                'name' => $feed->title,
                'url' => $feed->url,
            ]);
        }
        $postSlug = Helper::textToSlug($data->title);
        $postExist = Post::where('feed_id',$feedDb->id)->where('slug',$postSlug)->first();

        if (!$postExist){
            $postId = $this->postService->initializePost(1);
            $post = Post::find($postId);
            //TODO: Image Domain Replacement
            $data = [
                'feed_id' => $feedDb->id,
                'title'=>$data->title,
                'author'=>$data->author,
                'slug'=>$postSlug,
                'guid'=>$data->guid,
                'description'=>$data->content_clean_html,
                'featured_image'=> $data->image,//$this->gService->downloadImage($data->image),
                'excerpt'=>$data->description,
                'posted_at'=>Carbon::parse($data->created_at)->format('Y-m-d H:i:s'),
                'date'=>Carbon::parse($data->date)->format('Y-m-d H:i:s'),
                'status'=>1
            ];
//            $notificationMsg = 'New Post From Feed:'.$feedDb->name;
//            $notificationUrl = route('feed-posts.edit',$post->id);
//            $this->gService->sendNewPostNotification($notificationMsg,$notificationUrl);

            Helper::AddActivity($post->id,'App\Models\Post','Post Added by feed');
            Post::where('id',$postId)->update($data);
        }




    }

    public function removeFeed(){

    }
}
