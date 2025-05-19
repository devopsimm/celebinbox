<?php

use App\Http\Controllers\Admin\ContentPositionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\Admin\AuthorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/authors', [WebController::class,'authorsPage'])->name('authors');
Route::get('/about-us', [WebController::class,'aboutUsPage'])->name('aboutUs');
Route::get('/privacy-policy', [WebController::class,'policyPage'])->name('policy');
Route::get('/contact-us', [WebController::class,'contactUsPage'])->name('contactUs');
Route::post('/contact-us', [WebController::class,'contactUsPost'])->name('contactUsPost');



Route::get('latest-site-map.xml',[WebController::class,'generateLatestSiteMap'])->name('latestSiteMap');

Route::get('site-maps/categories/{category}.xml',[WebController::class,'generateCategorySiteMaps'])->name('catSiteMap');
Route::get('site-maps/sitemap.xml',[WebController::class,'generateMainSiteMaps']);
Route::get('site-maps/{m}-{y}.xml',[WebController::class,'generateMonthlySiteMaps']);



Route::group(['prefix'=>'admin'], function () {
    require __DIR__.'/auth.php';
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'twoFactor'])->name('dashboard');


Route::post('/get-posts', [FeedsController::class, 'getFeed']);
Route::get('/get-feeds', [FeedsController::class, 'getFeed']);

Route::group(['middleware'=>['auth','twoFactor'],'prefix'=>'admin'], function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/assign-role-permission',[PermissionController::class,'assignRolePermission'])->name('assignRolePermission');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('feed-posts', PostController::class);


    Route::get('/ajax-templates/{key}', [DashboardController::class, 'templates'])->name('templates');
    Route::post('/gallery/ajax_delete_gallery_image', [GalleryController::class, 'deleteImgAjax'])->name('deleteImgAjax');

    Route::post('/posts/uploadEditorImages', [PostController::class, 'uploadEditorImages'])->name('uploadEditorImages');
    Route::post('/posts/deleteEditorImages', [PostController::class, 'deleteEditorImages'])->name('deleteEditorImages');
    Route::post('/posts/getRelatedPosts', [PostController::class, 'getRelatedPosts'])->name('getRelatedPosts');
    Route::post('/posts/getAuthorsBySourceType', [PostController::class, 'getAuthorsBySourceType'])->name('getAuthorsBySourceType');
    Route::post('/posts/bulk/action', [PostController::class, 'bulkPostSubmit'])->name('bulkPostSubmit');

    Route::get('/posts/{id}/rephraseContent/', [PostController::class, 'rephraseContent'])->name('rephraseContent');
    Route::get('/posts/{id}/rephraseTitle/', [PostController::class, 'rephraseTitle'])->name('rephraseTitle');
    Route::get('/posts/{id}/rephraseExcerpt/', [PostController::class, 'rephraseExcerpt'])->name('rephraseExcerpt');
    Route::get('/posts/{id}/revert-original/', [PostController::class, 'revertOriginal'])->name('revertOriginal');
    Route::get('/posts/{id}/view-history/{metaId}/', [PostController::class, 'viewHistory'])->name('viewHistory');
    Route::get('/posts/{id}/revert-history/{metaId}/', [PostController::class, 'revertHistory'])->name('revertHistory');




    Route::get('/editorEmbeds', [PostController::class, 'editorEmbeds'])->name('editorEmbeds');
    Route::post('/categories/getChildCategories', [CategoryController::class, 'getChildCategories'])->name('getChildCategories');

    Route::post('/upload/', [DashboardController::class, 'tinyUpload'])->name('tinyUpload');

    Route::resource('content-positions', ContentPositionController::class);
    Route::get('/content-positions/{id}/posts', [ContentPositionController::class, 'contentPosts'])->name('contentPosts');
    Route::get('/content-positions/{id}/products', [ContentPositionController::class, 'contentProducts'])->name('contentProducts');
    Route::post('/content-positions/add-posts', [ContentPositionController::class, 'addContentPositionPost'])->name('addContentPositionPost');
    Route::post('/content-positions/remove-posts', [ContentPositionController::class, 'removeContentPositionPost'])->name('removeContentPositionPost');
    Route::resource('authors', AuthorController::class);
    Route::post('/posts/getAuthorsBySourceType', [PostController::class, 'getAuthorsBySourceType'])->name('getAuthorsBySourceType');
    Route::post('/posts/getAuthorsBySourceTypeForLiveBlog', [PostController::class, 'getAuthorsBySourceTypeForLiveBlog'])->name('getAuthorsBySourceTypeForLiveBlog');


});
Route::group(['prefix' => 'dev'], function () {
    Route::get('/test', [DevController::class,'test']);//->name('home');
    Route::get('/clear-cache',[DevController::class,'purgeApplication']);
    Route::get('/send-notification',[DevController::class,'sendNotification']);
    Route::get('/image-test',[DevController::class,'ImgTest']);
});

Route::group(['middleware'=>['throttle:120,1']], function () {

    Route::get('/', [WebController::class,'homePage'])->name('home');
    Route::get('/home', [WebController::class,'homePage']);
    Route::get('/latest', [WebController::class, 'latest'])->name('latest');
    Route::get('category/{mainCat}', [WebController::class, 'categoryPage'])->name('categoryPage');
    Route::get('category/{mainCat}/{subCat}', [WebController::class, 'subCategoryPage'])->name('subCategoryPage');
    Route::get('/load-more-posts/{type?}/{id?}',[WebController::class,'loadMorePosts'])->name('loadMorePosts');
    Route::get('/{slug}', [WebController::class, 'postDetails'])->name('slugPage');

    Route::get('/faq', [WebController::class,'faqPage'])->name('faq');


});


