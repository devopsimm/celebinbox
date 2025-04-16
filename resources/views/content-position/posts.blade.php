<x-app-layout>

    <x-slot name="header">
        {{ $contentPosition->key }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ $contentPosition->key }}
                            </span>

                             <div class="float-right">

                              </div>
                        </div>
                    </div>
                    <x-alertBox />
                    <div class="card-body">
                        <form action="">
                            <b>Slots: <span id="remaingSlots">{{ $contentPosition->slots }}</span>/{{ $contentPosition->slots }}</b> <br>

                            <div class="row relatedPostsRow">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Search {{ $contentPosition->content_type == '1' ?'Posts':'Products' }}</label>
                                        <input type="text" id="relatedPosts" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="button" id="searchRelatedPost" value="Search" class="btn btn-primary btn-sm" style="margin-top: 30px">
                                </div>
                                <div class="relatedPostsPopup">
                                    <span class="PopUpClose">x</span>
                                    <div class="holder"></div>
                                </div>
                                <div id="relatedPostsHolder">
                                    @if(count($posts))
                                        @foreach($posts as $key=>$post)
                                            <div class="relatedPost">
                                                <span class="removeRelatedPost" data-id="{{ $post->id }}" onclick="removeRelatedPost(this)">-</span>
                                                <b>{{ $post->title }}</b>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>


                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


@push('scripts')
    <script !src="">
        const getRelatedPosts = "{{ $contentPosition->content_type == '1' ? route('getRelatedPosts') : route('getRelatedProducts') }}";
        const addContentPositionPost = "{{ route('addContentPositionPost') }}";
        const removeContentPositionPost = "{{ route('removeContentPositionPost') }}";
        const content_position_id = "{{ $contentPosition->id }}";
        const totalSlots  = {{ $contentPosition->slots }};
        let totalPosts = {{ count($posts) }}
    </script>
    <script>
        updateSlots();

        function updateSlots(){
            $("#remaingSlots").html(totalSlots - totalPosts);
        }


        let relatedPostsPopup = $(".relatedPostsPopup");

        relatedPostsPopup.hide();
        $("#searchRelatedPost").click(function (){
            let postId = $("#post_edit_id").val();
            let htmlHolder = $(".relatedPostsPopup .holder");
            let relatedPosts = $("#relatedPosts");
            let val = relatedPosts.val();
            if(val !== ''){
                let ele = $(this);
                ele.prop('disabled',true);
                relatedPosts.prop('disabled',true);
                $.ajax({
                    url: getRelatedPosts,
                    method: 'POST',
                    data: {
                        search:val,
                        postId:postId,
                    },
                    success: function (res) {
                        if(res == '404'){

                        }else{
                            let lists = JSON.parse(res);
                            let html = '<ul>';
                            $.each(lists,function (key,val){
                                html += '<li data-key="'+key+'" data-value="'+val+'" onclick="addRelatedPost(this)" >';
                                html += '<b>'+val+'</b>';
                                html += '</li>';
                            });
                            html += '</ul>';
                            htmlHolder.html(html);
                            relatedPostsPopup.show();

                        }
                        // $.unblockUI();
                    },
                    complete: function (){
                        ele.prop('disabled',false);
                        relatedPosts.prop('disabled',false);
                    }
                });

            }


        });

        $(".relatedPostsPopup .PopUpClose").click(function (){
            relatedPostsPopup.hide();
        });
        function addRelatedPost(th){
            let ele = $(th);
            let key = ele.attr('data-key');
            let value = ele.attr('data-value');
            let html = '<div class="relatedPost">';
            html += '<span class="removeRelatedPost" data-id="'+key+'" onclick="removeRelatedPost(this)">-</span>';
            html += '<b>'+value+'</b>';
            html += '</div>';

            if(totalPosts !== totalSlots){
                $.ajax({
                    url: addContentPositionPost,
                    method: 'POST',
                    data: {
                        content_position_id:content_position_id,
                        postId:key,
                    },
                    success: function (res) {
                        if (res !== 0){
                            $("#relatedPostsHolder").append(html);
                            totalPosts =totalPosts + 1;
                            updateSlots();
                        }else{
                            alert('Post Already Added');
                        }

                    }
                });
            }else{
                alert('Slots not available');
            }



        }

        function removeRelatedPost(th){
            let ele = $(th);
            let key = ele.attr('data-id');
            $.ajax({
                url: removeContentPositionPost,
                method: 'POST',
                data: {
                    content_position_id:content_position_id,
                    postId:key,
                },
                success: function (res) {
                    if (res !== 0){
                        ele.parent().remove();
                        totalPosts =totalPosts - 1;
                        updateSlots();
                    }else{
                        alert('Post Already Added');
                    }

                }
            });



        }
    </script>
    <style>
        .relatedPostsPopup {
            overflow-y: scroll;
            box-shadow: 0px 0px 5px 4px #d9d9d9;
            border-radius: 9px;
        }
        div#relatedPostsHolder {
            width: fit-content !important;
        }
    </style>
@endpush
</x-app-layout>
