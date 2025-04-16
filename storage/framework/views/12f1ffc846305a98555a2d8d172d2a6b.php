<div class="smlItem  smlOne">
    <article class="itemInner">
        <div class="itemContent">
            <a class="bgImg"
               href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
               title="<?php echo e($post->title); ?>"
               style="background-image: url('<?php echo e(Helper::getFeaturedImg(['post'=>$post])); ?>');"></a>
        </div>
        <div class="content-container">
            <h2 class="title">
                <a href="<?php echo e(route('slugPage',$post->id.'-'.$post->slug)); ?>"
                   title="<?php echo e($post->title); ?>"
                   class="post-url post-title"><?php echo e($post->title); ?></a>
            </h2>
        </div>
    </article>
</div>
<?php /**PATH D:\laragon\www\celebinbox\resources\views/layouts/partials/web/smallBgThumForCatPage.blade.php ENDPATH**/ ?>