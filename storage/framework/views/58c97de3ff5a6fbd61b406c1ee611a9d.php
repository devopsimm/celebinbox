<div class="lastSec_list">
    <div class="commonHeading">
        <p class="mt-0"><a title="<?php echo e($cat); ?>"
                           href="<?php echo e(route('categoryPage',$slug)); ?>"><?php echo e($cat); ?></a></p>
        <span></span>
    </div>
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first): ?>
    <div class="topImage">
        <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
           title="<?php echo e($post->title); ?>"
           class="open-section">
            <img class="lazyload"
                 alt="<?php echo e($post->title); ?>"
                 title="<?php echo e($post->title); ?>"
                 src="<?php echo e(config('settings.placeholderImg370')); ?>"
                 data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$post],'370X222')); ?>"
                 width="370" height="222">
            <div class="imgDtl">
                <div class="imgDtlInner">
                    <div><?php echo e($post->title); ?></div>
                </div>
            </div>
        </a>
    </div>
    <div class="listing">
        <ul class="listingMain">
        <?php endif; ?>
         <?php if(!$loop->first): ?>
                <li>
                    <?php echo $__env->make('layouts.partials.web.postThumbnailSmall',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </li>
            <?php endif; ?>
        <?php if($loop->last): ?>
        </ul>
    </div>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH F:\laragon\www\contentfeeds\resources\views/layouts/partials/web/postVerticalSection.blade.php ENDPATH**/ ?>