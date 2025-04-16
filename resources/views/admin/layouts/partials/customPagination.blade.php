<ul class="customPagination">
    @if($meta['page'] != 1)
        <li><a href="{{ route($meta['route'],['page'=>$meta['page']-1]) }}">Previous</a></li>
    @endif
    @for($i = 1; $i <= $meta['last_page'];$i++)
        <li class="{{ ($meta['page'] == $i)?'active':'' }}"><a href="{{ route($meta['route'],['page'=>$i]) }}">{{ $i }}</a></li>
    @endfor
    @if($meta['page'] != $meta['last_page'])
        <li><a href="{{ route($meta['route'],['page'=>$meta['page']+1]) }}">Next</a></li>
    @endif
</ul>

<style>
    ul.customPagination li {
        float: left;
        margin-right: 3px;
        padding: 10px;
    }

    ul.customPagination li.active,ul.customPagination li:hover {
        background: #1e2835;
        color: #fff;
    }
</style>
