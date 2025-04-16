<header id="site-header" class="header">
    <div class="container">
        <nav class="navbar">
            <a class="brand" onclick="analyticsFunc(this)" data-event_action="top_nav" data-event_label="site_logo"
               data-page_type="Homepage" data-event="top_navigation_menu" href="<?php echo e(route('home')); ?>"
               title="The Celeb Inbox">
                <img src="<?php echo e(url('website/logo.png')); ?>" width="255"
                     height="42" alt="The Celeb Inbox">
            </a>
            <input type="checkbox" id="nav" class="hidden">
            <label for="nav" class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <div class="wrapper">
                <ul class="menu">
                    <li class="menu-item">
                        <a href="<?php echo e(route('latest')); ?>" title="Latest Stories">Latest</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('categoryPage','world')); ?>" title="world">World</a>
                    </li>

                    <li class="menu-item">
                        <a href="<?php echo e(route('categoryPage','sports')); ?>" title="sports">Sports</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('categoryPage','health')); ?>" title="health">Health</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('categoryPage','entertainment')); ?>" title="entertainment">Entertainment</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('categoryPage','royal')); ?>" title="Royal">Royal</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

</header>
<?php /**PATH F:\laragon\www\contentfeeds\resources\views/layouts/partials/web/header.blade.php ENDPATH**/ ?>