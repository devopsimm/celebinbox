<div class="section_right">
    <div class="sideBarFixed_">
        <?php if(isset($mostReadPosts) && count($mostReadPosts) > 0): ?>
        <div id="mostreadAppend" class="royal" style="margin-bottom: 30px;">
            <div class="commonHeading">
                <p class="mt-0"><a title="Royals" href="#_">Most Read</a></p>
                <span></span>
            </div>
            <div class="listing">
                <ul class="listingMain">
                    <?php $__currentLoopData = $mostReadPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php echo $__env->make('layouts.partials.web.postThumbnailSmall', ['post' => $post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
            <?php if(isset($sideCats) && count($sideCats) > 0): ?>
                <?php $__currentLoopData = $sideCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sideCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($sideCat)): ?>
                        <div id="royalAppend" class="royal">
                            <div class="commonHeading">
                                <p class="mt-0"><a title="<?php echo e($key); ?>"
                                                   href="<?php echo e(route('categoryPage',$key)); ?>"><?php echo e($key); ?></a></p>
                                <span></span>
                            </div>
                            <div class="listing">
                                <ul class="listingMain">
                                    <?php $__currentLoopData = $sideCat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo $__env->make('layouts.partials.web.postThumbnailSmall', ['post' => $post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <?php endif; ?>
    </div>
</div>
<?php /**PATH F:\laragon\www\contentfeeds\resources\views/layouts/partials/web/rightSideBar.blade.php ENDPATH**/ ?>