<div class="smlItem  smlOne">
    <article class="itemInner">
        <div class="itemContent">
            <a class="bgImg"
               href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
               title="{{ $post->title }}"
               style="background-image: url('{{ Helper::getFeaturedImg(['post'=>$post]) }}');"></a>
        </div>
        <div class="innerBadge">
          <span>
              <a class="{{ optional($post->MainCategory)->color ?? 'blue' }}" href="{{ route('categoryPage',$post->MainCategory->slug) }}" title="{{ ucfirst($post->MainCategory->name) }}">{{ ucfirst($post->MainCategory->name) }}</a>
          </span>
        </div>
        <div class="content-container">
            <h2 class="title">
                <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
                   title="{{ $post->title }}"
                   class="post-url post-title">{{ $post->title }}</a>
            </h2>
        </div>
    </article>
</div>
