<?php $__env->startPush('meta'); ?>
    <title>The Celeb Inbox: Entertainment - Latest Celebrity News, Gossip & Photos - The Celeb Inbox</title>
    <meta name='TITLE' content="The Celeb Inbox: Entertainment - Latest Celebrity News, Gossip & Photos - The Celeb Inbox">
    <meta name="description" content="Get the Latest Entertainment, Celebrity News and Updates on Your Favorite Stars, Taylor Swift, Meghan Markle, Prince harry, King Charles">
    <meta name="keywords" content="Meghan Markle, Prince Harry, Kate Middleton, Prince William, Drake, Taylor Swift, Zendaya, Bad Bunny, Ariana Grande, Billie Eilish, Lady Gaga, Tom Holland, Selena Gomez, Travis Scott, Kim Kardashian, Kanye West">

<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(url('website/home.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(count($bannerPosts) == 5): ?>

    <div class="home_featured_story">
        <div class="container">
            <ul>
                <li>
                    <div class="h_featured_pic pic_all largeTop">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[0]->id.'-'.$bannerPosts[0]->slug)); ?>"
                           title="<?php echo e($bannerPosts[0]->title); ?>"
                           class="open-section">
                            <img class="lazyload"
                                 alt="<?php echo e($bannerPosts[0]->title); ?>"
                                 title="<?php echo e($bannerPosts[0]->title); ?>"
                                 src="<?php echo e(config('settings.placeholderImgFull')); ?>"
                                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$bannerPosts[0]],'700X390')); ?>"
                                 width="700" height="390">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="<?php echo e($bannerPosts[0]->MainCategory->color); ?>" href="<?php echo e(route('categoryPage',$bannerPosts[0]->MainCategory->slug)); ?>"
                                   title="<?php echo e(ucfirst($bannerPosts[0]->MainCategory->name)); ?>"><?php echo e(ucfirst($bannerPosts[0]->MainCategory->name)); ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[0]->id.'-'.$bannerPosts[0]->slug)); ?>"
                           title="<?php echo e($bannerPosts[0]?->title ?? 'None'); ?>"
                           class="open-section">
                            <h1><?php echo e($bannerPosts[0]?->title ?? 'None'); ?></h1>
                        </a>
                    </div>
                </li>
            </ul>
            <ul>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[1]->id.'-'.$bannerPosts[1]->slug)); ?>"
                           title="<?php echo e($bannerPosts[1]->title); ?>" class="open-section">
                            <img class="lazyload" alt="<?php echo e($bannerPosts[1]->title); ?>"
                                 title="<?php echo e($bannerPosts[1]->title); ?>"
                                 src="<?php echo e(config('settings.placeholderImgFull')); ?>"
                                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$bannerPosts[1]],'370X222')); ?>"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="<?php echo e($bannerPosts[1]->MainCategory->color); ?>" href="<?php echo e(route('categoryPage',$bannerPosts[1]->MainCategory->slug)); ?>"
                                   title="<?php echo e(ucfirst($bannerPosts[1]->MainCategory->name)); ?>"><?php echo e(ucfirst($bannerPosts[1]->MainCategory->name)); ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[1]->id.'-'.$bannerPosts[1]->slug)); ?>"
                           title="<?php echo e($bannerPosts[1]->title); ?>" class="open-section">
                            <h2><?php echo e($bannerPosts[1]->title); ?></h2>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[2]->id.'-'.$bannerPosts[2]->slug)); ?>"
                           title="<?php echo e($bannerPosts[2]->title); ?>" class="open-section">
                            <img class="lazyload" alt="<?php echo e($bannerPosts[2]->title); ?>"
                                 title="<?php echo e($bannerPosts[2]->title); ?>"
                                 src="<?php echo e(config('settings.placeholderImgFull')); ?>"
                                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$bannerPosts[2]],'370X222')); ?>"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="<?php echo e($bannerPosts[2]->MainCategory->color); ?>" href="<?php echo e(route('categoryPage',$bannerPosts[2]->MainCategory->slug)); ?>"
                                   title="<?php echo e(ucfirst($bannerPosts[2]->MainCategory->name)); ?>"><?php echo e(ucfirst($bannerPosts[2]->MainCategory->name)); ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[2]->id.'-'.$bannerPosts[2]->slug)); ?>"
                           title="<?php echo e($bannerPosts[2]->title); ?>" class="open-section">
                            <h2><?php echo e($bannerPosts[2]->title); ?></h2>
                        </a>
                    </div>
                </li>
            </ul>
            <ul>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[3]->id.'-'.$bannerPosts[3]->slug)); ?>"
                           title="<?php echo e($bannerPosts[1]->title); ?>" class="open-section">
                            <img class="lazyload" alt="<?php echo e($bannerPosts[3]->title); ?>"
                                 title="<?php echo e($bannerPosts[3]->title); ?>"
                                 src="<?php echo e(config('settings.placeholderImgFull')); ?>"
                                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$bannerPosts[3]],'370X222')); ?>"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="<?php echo e($bannerPosts[3]->MainCategory->color); ?>" href="<?php echo e(route('categoryPage',$bannerPosts[3]->MainCategory->slug)); ?>"
                                   title="<?php echo e(ucfirst($bannerPosts[3]->MainCategory->name)); ?>"><?php echo e(ucfirst($bannerPosts[3]->MainCategory->name)); ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[3]->id.'-'.$bannerPosts[3]->slug)); ?>"
                           title="<?php echo e($bannerPosts[3]->title); ?>" class="open-section">
                            <h2><?php echo e($bannerPosts[3]->title); ?></h2>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[4]->id.'-'.$bannerPosts[4]->slug)); ?>"
                           title="<?php echo e($bannerPosts[1]->title); ?>" class="open-section">
                            <img class="lazyload" alt="<?php echo e($bannerPosts[4]->title); ?>"
                                 title="<?php echo e($bannerPosts[4]->title); ?>"
                                 src="<?php echo e(config('settings.placeholderImgFull')); ?>"
                                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$bannerPosts[4]],'370X222')); ?>"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="<?php echo e($bannerPosts[4]->MainCategory->color); ?>" href="<?php echo e(route('categoryPage',$bannerPosts[4]->MainCategory->slug)); ?>"
                                   title="<?php echo e(ucfirst($bannerPosts[4]->MainCategory->name)); ?>"><?php echo e(ucfirst($bannerPosts[4]->MainCategory->name)); ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="<?php echo e(route('slugPage',$bannerPosts[4]->id.'-'.$bannerPosts[4]->slug)); ?>"
                           title="<?php echo e($bannerPosts[4]->title); ?>" class="open-section">
                            <h2><?php echo e($bannerPosts[4]->title); ?></h2>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <div class="news_section">
        <div class="container">
            <div class="section_wrapper">
                <div class="section_left">
                    <?php if(isset($homeCats['entertainment'])): ?>
                    <div class="commonHeading">
                        <p class="mt-0"><a title="Celebrity"
                                           href="<?php echo e(route('categoryPage','entertainment')); ?>">Entertainment</a></p>
                        <span></span>
                    </div>
                    <ul class="newsRows">
                        <?php $__currentLoopData = $homeCats['entertainment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                           <?php echo $__env->make('layouts.partials.web.postThumbnail',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                </div>
                    <?php echo e(Helper::displayRightSideBar()); ?>


            </div>
        </div>
    </div>
    <div class="lastSec">
        <div class="container">
            <div class="lastSec_wrapper">

                <?php echo $__env->make('layouts.partials.web.postVerticalSection',['color'=>'pink','cat'=>'World','slug'=>'world','posts'=>$homeCats['world']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('layouts.partials.web.postVerticalSection',['color'=>'purple','cat'=>'Sports','slug'=>'sports','posts'=>$homeCats['sports']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('layouts.partials.web.postVerticalSection',['color'=>'blue','cat'=>'Health','slug'=>'health','posts'=>$homeCats['health']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>
        </div>
    </div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\contentfeeds\resources\views/website/home.blade.php ENDPATH**/ ?>