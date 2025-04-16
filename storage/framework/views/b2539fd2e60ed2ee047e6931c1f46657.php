<div class="imgList">
    <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
       title="<?php echo e($post->title); ?>" class="open-section">
        <img class="lazyload" alt="<?php echo e($post->title); ?>"
             title="<?php echo e($post->title); ?> "
             src="<?php echo e(config('settings.placeholderImg100')); ?>"
             data-src="<?php echo e(Helper::getFeaturedImg(['post'=>$post],'100X60')); ?>"
             width="100" height="60">
    </a>
</div>
<div class="contentList">
    <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
       title="<?php echo e($post->title); ?>" class="open-section">
        <?php echo e($post->title); ?> </a>
</div>
<?php /**PATH D:\laragon\www\celebinbox\resources\views/layouts/partials/web/postThumbnailSmall.blade.php ENDPATH**/ ?>