<x-app-layout>

    <x-slot name="header">
       <div>
           <span>Update Post</span>

       </div>

    </x-slot>


    <section class="content container-fluid" style="padding: 0; ">
        <div class="">
            <div class="col-md-12">
  <x-alertBox />


                <div class="card card-default" style="padding: 0; margin: 0">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <span class="card-title">Update Post</span>
                     <div>
                         @if($post->is_rephrase == 1 || $post->is_title_rephrased == 1  || $post->is_excerpt_rephrased == 1  )
                         <a href="#." id="viewOrg" class="btn btn-dark text-white">View Original</a>
                         <a href="#." id="closeBtn" style="display:none;" class="btn btn-dark text-white">Hide Original</a>
                         <a href="{{ route('revertOriginal',$post->id) }}" class="loaderLink btn btn-primary">Revert Original</a>
                         @endif
                             <a href="{{ route('rephraseTitle',$post->id) }}" id="rephraseLink" class="loaderLink btn btn-primary">Rephrase Title & Excerpt</a>
{{--                             <a href="{{ route('rephraseExcerpt',$post->id) }}" id="rephraseLink2" class="loaderLink btn btn-primary">Rephrase Excerpt</a>--}}
                             <a href="{{ route('rephraseContent',$post->id) }}" id="rephraseLink3" class="loaderLink btn btn-primary">Rephrase Body</a>
                     </div>
                    </div>
                    <div class="card-body">
                        <form id="postForm" class="validate" method="POST" action="{{ route('feed-posts.update', $post->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('post.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
