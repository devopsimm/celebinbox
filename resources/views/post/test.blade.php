@extends('../admin/layouts.app')



@section('content')

    <form action="{{ route('adminTest') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="submit" value="submit">
    </form>

@endsection
