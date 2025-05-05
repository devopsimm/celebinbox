<footer>
    <div class="container">
        <div class="footerMenu">
            <ul>
                <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                <li>
                    <a href="<?php echo e(route('latest')); ?>" title="Latest Stories">Latest</a>
                </li>
                <li><a href="<?php echo e(route('categoryPage','world')); ?>" title="world">World</a></li>
                <li><a href="<?php echo e(route('categoryPage','sports')); ?>" title="sports">Sports</a></li>
                <li> <a href="<?php echo e(route('categoryPage','health')); ?>" title="health">Health</a></li>
                <li> <a href="<?php echo e(route('categoryPage','entertainment')); ?>" title="entertainment">Entertainment</a></li>
                <li> <a href="<?php echo e(route('categoryPage','royal')); ?>" title="Royal">Royal</a></li>
            </ul>
        </div>
        <p class="copyRight">Copyright @ 2025 - CelebInbox.com | All Rights Reserved. |  <a href="<?php echo e(route('contactUs')); ?>">Contact</a> |
            <a href="<?php echo e(route('aboutUs')); ?>">About</a> | <a href="<?php echo e(route('policy')); ?>">Privacy Policy</a></p>
    </div>
</footer>
<?php /**PATH F:\laragon\www\contentfeeds\resources\views/layouts/partials/web/footer.blade.php ENDPATH**/ ?>