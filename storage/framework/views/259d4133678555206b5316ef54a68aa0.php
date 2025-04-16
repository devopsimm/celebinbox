<?php $__env->startPush('meta'); ?>
    <title><?php echo e($post->title); ?></title>
    <meta name='TITLE' content="<?php echo e($post->title); ?>">
    <meta name="description" content="<?php echo e($post->excerpt); ?>">
    <meta name="keywords" content="Meghan Markle, Prince Harry, Kate Middleton, Prince William, Drake, Taylor Swift, Zendaya, Bad Bunny, Ariana Grande, Billie Eilish, Lady Gaga, Tom Holland, Selena Gomez, Travis Scott, Kim Kardashian, Kanye West">

<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('website/detail.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('metas'); ?>
    <meta property="og:title" content="<?php echo e((isset($metas['meta_title']) && $metas['meta_title']->value != '')?$metas['meta_title']->value:$post->title); ?>" />
    <meta property="og:image" content="<?php echo e(Helper::getFileUrl($post->featured_image,$post,'post')); ?>" />
    <meta property="og:description" content="<?php echo e((isset($metaDescription))? $metaDescription : $post->excerpt); ?>" />
    <meta property="og:url" content="<?php echo e(route('slugPage',$post->slug.'-'.$post->id)); ?>">
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="CelebInbox">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Celebinbox">
    <meta name="twitter:creator" content="@Web Desk" />
    <meta name="twitter:title" content="<?php echo e((isset($metas['meta_title']) && $metas['meta_title']->value != '')?$metas['meta_title']->value:$post->title); ?>">
    <meta name="twitter:description" content="<?php echo e((isset($metaDescription))? $metaDescription : $post->excerpt); ?>">
    <meta name="twitter:image" content="<?php echo e(Helper::getFileUrl($post->featured_image,$post,'post')); ?>">


    <?php $updatedAt = \Carbon\Carbon::parse($post->updated_at)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:sP'); ?>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "NewsArticle",
            "mainEntityofPage": "<?php echo e(url()->current()); ?>",
            "headline": "<?php echo e($post->title); ?>",
             "datePublished": "<?php echo e(\Carbon\Carbon::parse($post->posted_at)->format('Y-m-d\TH:i:sP')); ?>",
             "dateModified": "<?php echo e(\Carbon\Carbon::parse($updatedAt)->format('Y-m-d\TH:i:sP')); ?>",
             "description": "<?php echo e((isset($metaDescription))? $metaDescription : $post->excerpt); ?>",
             "image": {
                "@type": "ImageObject",
                "url": "<?php echo e(Helper::getFileUrl($post->featured_image,$post,'post')); ?>",
                "width": 1200,
                "height": 630
              },
              <?php if(isset($post->authors[0])): ?>
            "author": {
                              "@type":"Person",
                              "name":"<?php echo e($post->authors[0]->name); ?>",
                  "url":""
              },
              <?php endif; ?>

        "publisher": {
          "@type": "Organization",
          "name": "CelebInbox",
          "logo": {
            "@type": "ImageObject",
            "url": "<?php echo e(url('website/img/favicon-112x112.png')); ?>",
                "width": 112,
                "height": 112
              }
            }
        }


        </script>



























    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-RMFTG9NG1N', {
            'language':'English',
            'page_type':'Detail Page' ,
            'detail_page_type':'<?php echo e(($post->show_video_icon == 1) ? "Video Detail" : "Article Detail"); ?>' ,
            'sub_category':'<?php echo e(ucfirst($post->MainCategory->name)); ?>' ,
            'publish_date':'<?php echo e(\Carbon\Carbon::parse($post->posted_at)->format('d-M-Y')); ?>',
            'publish_time':'<?php echo e(\Carbon\Carbon::parse($post->posted_at)->format('H:i:s')); ?>',
            'update_date':'<?php echo e(\Carbon\Carbon::parse($updatedAt)->format('d-M-Y')); ?>',
            'article_word_count':<?php echo e(str_word_count(strip_tags($description))); ?> ,
            'desk_sub':"<?php echo e($post->user->name); ?>" ,
            
            'page_category':"<?php echo e(ucfirst($post->MainCategory->name)); ?>",
            'article_age':'<?php echo e(\Carbon\Carbon::parse($post->posted_at)->diffForHumans()); ?>' ,
            
            'story_id':<?php echo e($post->id); ?> , //7823
            'video_embed':'<?php echo e(($post->show_video_icon == 1) ? "Yes" : "No"); ?>' ,
            'ad_present' : 'No',
            'Contributors' : "",
        });
    </script>
<?php $__env->stopPush(); ?>



<?php $__env->startSection('content'); ?>
    <div class="detail_page">
        <div class="container">
            <div style="margin: 0px auto 10px; clear: both; text-align: center; float: left; width: 100%;">
                <div style="width: 330px;display: inline-block;border: 2px solid #7c7c7c; padding: 10px 20px; text-align: left; margin: 0 auto; border-radius: 10px;">
                    <div style="margin-bottom: 10px;font-size: 18px; font-weight: bold; text-align: left;">Trending</div>
                    <ul class="listingMain" style=" margin-left: 10px;">

                        <?php $__currentLoopData = $sideBarRelatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li style="list-style: disc;">
                                <div class="contentList" style="width: 100%;">
                                    <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                       class="open-section" style="height: auto;text-decoration:underline;"><?php echo e($post->title); ?></a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div class="hdStyle">
                <h3 class="title_category"><a href="<?php echo e(route('categoryPage',$post->MainCategory->slug)); ?>"><?php echo e($post?->MainCategory?->name ?? '-'); ?></a></h3>
                <h1 id="postTit"><?php echo e($post->title); ?></h1>
                <h2 class="description"><?php echo e($post->excerpt); ?></h2>
                <div class="aut_share">
                    <div class="authorDetail">
                        <div class="authorName">
                            <span>By&nbsp;</span><span style="margin-right: 12px;"><?php echo e('Web Desk'); ?></span>
                            <span class="time"><?php echo e(Carbon\Carbon::parse($post->posted_at)->format('d M Y')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="aut_share">
                    <div class="share">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/sharer.php?u=<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                    title="Facebook"><img
                                        src="<?php echo e(url('website/facebook-detail.svg')); ?>"
                                        alt="facebook" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/share?text=<?php echo e($post->title); ?>&url=<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                    title="Twitter"><img
                                        src="<?php echo e(url('website/twitter-detail.svg')); ?>"
                                        alt="twitter" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text=<?php echo e($post->title); ?>-<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                    title="Whatsapp"><img
                                        src="<?php echo e(url('website/whatsapp-detail.svg')); ?>"
                                        alt="whatsapp" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text=<?php echo e($post->title); ?>-<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                    title="Whatsapp"><img
                                        src="<?php echo e(url('website/pinterest-detail.svg')); ?>"
                                        alt="whatsapp" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text=<?php echo e($post->title); ?>-<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                                    title="Whatsapp"><img
                                        src="<?php echo e(url('website/email-detail.svg')); ?>"
                                        alt="whatsapp" width="30" height="30"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section_wrapper">
                <div class="section_left">
                    <div class="celebBreadCrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(route('home')); ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(route('categoryPage',$post->MainCategory->slug)); ?>"><?php echo e($post?->MainCategory?->name ?? '-'); ?></a>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="detail_wrapper">
                        <?php echo $description; ?>


                    </div>

                </div>

            </div>
                <?php if(count($relatedPosts)): ?>
                <div class="moreFrom">
                    <div class="commonHeading">
                        <p class="mt-0"><a class="red"
                                            href="<?php echo e(route('categoryPage',$post->MainCategory->slug)); ?>"><?php echo e($post?->MainCategory?->name ?? '-'); ?></a></p>
                        <span></span>
                    </div>
                    <ul style="margin-top: 0 !important;">
                        <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php echo $__env->make('layouts.partials.web.postThumbnailSmall', ['post' => $post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
                <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('figcaption').prop('contenteditable','false');
    </script>
    <style type="text/css">span {
    font-size: inherit !important;
}</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\celebinbox\resources\views/website/detailPage.blade.php ENDPATH**/ ?>