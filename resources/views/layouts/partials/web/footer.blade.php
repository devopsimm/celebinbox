<footer>
    <div class="container">
        <div class="footerMenu">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>
                    <a href="{{ route('latest') }}" title="Latest Stories">Latest</a>
                </li>
                <li><a href="{{ route('categoryPage','world') }}" title="world">World</a></li>
                <li><a href="{{ route('categoryPage','sports') }}" title="sports">Sports</a></li>
                <li> <a href="{{ route('categoryPage','health') }}" title="health">Health</a></li>
                <li> <a href="{{ route('categoryPage','entertainment') }}" title="entertainment">Entertainment</a></li>
                <li> <a href="{{ route('categoryPage','royal') }}" title="Royal">Royal</a></li>
            </ul>
        </div>
        <p class="copyRight">Copyright @ 2025 - CelebInbox.com | All Rights Reserved. |  <a href="{{ route('contactUs') }}">Contact</a> |
            <a href="{{ route('aboutUs') }}">About</a> | <a href="{{ route('policy') }}">Privacy Policy</a></p>
    </div>
</footer>
