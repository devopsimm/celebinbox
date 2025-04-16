<div class="imgBox">
    <?php if(isset($badge)): ?>
        
        <span><a class="<?php echo e($badge); ?>" href="<?php echo e(route('categoryPage',$post->MainCategory->slug)); ?>"
                 title="<?php echo e(ucfirst($post->MainCategory->name)); ?>">
                <?php echo e(ucfirst($post->MainCategory->name)); ?>

            </a>
        </span>
    <?php endif; ?>

    <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
       title="<?php echo e($post->title); ?> "
       class="open-section">
        <img class="lazyload"
             alt="<?php echo e($post->title); ?>  "
             title="<?php echo e($post->title); ?> "
             src="<?php echo e(config('settings.placeholderImgFull')); ?>"
             data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$post],'370X222')); ?>"
             width="370" height="222">
    </a>
</div>

<div class="newsDetail">
    <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
       title="<?php echo e($post->title); ?> "
       class="open-section">
        <?php echo e($post->title); ?>  </a>
    <p><?php echo e($post->title); ?> </p>
</div>
<?php /**PATH D:\laragon\www\celebinbox\resources\views/layouts/partials/web/postThumbnail.blade.php ENDPATH**/ ?>