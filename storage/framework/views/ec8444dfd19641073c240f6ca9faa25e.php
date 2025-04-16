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
                            <?php echo $__env->make('layouts.partials.web.smallBgThumForCatPage',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="smlRow1 clearfix">
                        <?php $__currentLoopData = array_slice($posts, 3, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('layouts.partials.web.smallBgThumForCatPage',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                        <?php $__currentLoopData = array_slice($posts, 5, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li>
                               <?php echo $__env->make('layouts.partials.web.postThumbnail',['post'=>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                    <div id="loading-spinner" style="display: none">
                        <div class="spinner"></div>
                    </div>
                    <div class="text-center my-3">
                        <button id="load-more-button" class="btn btn-primary theme_btn_load">Load More</button>
                    </div>
                </div>
                <?php echo e(Helper::displayRightSideBar()); ?>

            </div>
            <div class="category_detail_section">

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <input type="hidden" id="PC_LoadMore" value="<?php echo e($loadMoreRoute); ?>">

    <script>
        const route = $("#PC_LoadMore").val();
        let morePosts = true;
        let isAjax = false;
        let page = 3; // Start at page 2
        $(document).ready(function() {

            loadMorePosts();

        });

        $('#load-more-button').click(function() {
            loadMorePosts();
        });
        function loadMorePosts() {

            if (morePosts == true) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    data: {page: page, limit: 5, returnType: 'html'},
                    beforeSend: function () {
                        $('#loading-spinner').show(); // Show the loading spinner
                        isAjax = true;
                    },
                    success: function (data) {
                        if (data !== '404') {
                            $("#load-more").append(data)
                            page++; // Increment the page number
                        } else {
                            $("#load-more-button").prop('disabled',true);
                            morePosts = false;
                            $('#load-more').append('<p>No more posts to load</p>');
                        }
                        isAjax = false;
                        $('#loading-spinner').hide(); // Hide the loading spinner
                    }
                });
            }
        }

        $(window).scroll(function() {
            if($("#load-more-button").isVisible()) {
                if (!isAjax){
                    // alert(isAjax);
                    loadMorePosts();
                }
            }
        });
        function scrollTo(id){

            $('html, body').animate({
                scrollTop: $("#"+id).offset().top
            }, 2000);
        }


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\celebinbox\resources\views/website/postCategories.blade.php ENDPATH**/ ?>