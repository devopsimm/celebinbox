<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use App\Services\GeneralService;
use Illuminate\Http\Request;

class DevController extends Controller
{

    public function purgeApplication(){
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        //    \Artisan::call('view:cache');
        \Artisan::call('view:clear');

        // Alert::success('Cache has been cleared !')->persistent('Close')->autoclose(6000);

        return back();
    }
   public function sendNotification(){
       $message = 'Click here to view the new updates!';
       $url = url('/updates');
       $usersWithRole = User::role(['Admin','Post Editor'])->get();
       foreach ($usersWithRole as $user) {
           $user->notify(new NewPostNotification($message, $url));
       }

       return true;

   }
   public function ImgTest(){
        $post = Post::find(75);
        $service = new GeneralService();

        $detail = $service->downloadImage($post->featured_image);
        dd($detail);
   }
   public function test(){
       return view('website.test');

   }
}
