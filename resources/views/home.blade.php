@if (isset($scriptTag) && !empty($scriptTag))
    <form action="{{ route('script-tag.destroy', ['id' => $scriptTag->id ]) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="delete script tag">
    </form>
@else
    <form action="{{ route('script-tag.store') }}" method="post">
        @csrf
        <input type="submit" value="add script tag">
    </form>
@endif

<a href="{{ route('script-tag.url') }}">script tag</a>



@dd("home page")