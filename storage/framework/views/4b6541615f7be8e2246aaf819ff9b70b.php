<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('website/category.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(count($posts) >= 5): ?>
    <div class="innerFeat">
        <div class="container">
            <div class="topMain">
                <div class="featBig">
                    <article class="innerListing">
                        <div class="itemContent">
                            <a class="bgImg"
                               href="<?php echo e(route('slugPage',$posts[0]->id.'-'.$posts[0]->slug)); ?>"
                               title="<?php echo e($posts[0]->title); ?>"
                               style="background-image: url('<?php echo e(Helper::getFeaturedImg(['post'=>$posts[0]])); ?>');"></a>
                               <div class="innerBadge">
                                            <span>
                                                <a class="<?php echo e(optional($posts[0]->MainCategory)->color ?? 'blue'); ?>" href="<?php echo e(route('categoryPage',$posts[0]->MainCategory->slug)); ?>" title="<?php echo e(ucfirst($posts[0]->MainCategory->name)); ?>"><?php echo e(ucfirst($posts[0]->MainCategory->name)); ?></a>
                                            </span>
                                        </div>
                            <div class="content-container">
                                <h2 class="title">
                                    <a href="<?php echo e(route('slugPage',$posts[0]->id.'-'.$posts[0]->slug)); ?>"
                                       title="<?php echo e($posts[0]->title); ?>" class="post-url post-title">
                                        <?php echo e($posts[0]->title); ?>

                                    </a>
                                </h2>
                                <h3 style="font-size:14px;margin: 5px 0;color: #d1d1d1;"><?php echo e($posts[0]->excerpt); ?> </h3>

                            </div>
                        </div>
                    </article>
                </div>
                <div class="featSml">
                    <div class="smlRow1 clearfix">
                        <?php $__currentLoopData = array_slice($posts, 1, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('layouts.partials.web.smallBgThumForLatestPage',['post'=>$post ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="smlRow1 clearfix">
                        <?php $__currentLoopData = array_slice($posts, 3, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('layouts.partials.web.smallBgThumForLatestPage',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="news_section">
        <div class="container">
            <div class="section_wrapper">
                <div class="section_left">

                    <ul class="newsRows" id="load-more">
                        <?php $__currentLoopData = array_slice($posts, 5, 15); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li>
                               <?php echo $__env->make('layouts.partials.web.postThumbnail',['post'=>$post,'badge'=>optional($post->MainCategory)->color ?? 'blue'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                </div>
                <?php echo e(Helper::displayRightSideBar()); ?>

            </div>
            <div class="category_detail_section">

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\celebinbox\resources\views/website/latest.blade.php ENDPATH**/ ?>