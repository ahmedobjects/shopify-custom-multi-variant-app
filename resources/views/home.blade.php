@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

            <form action="{{ route('app-config.activity', ['id' => $user->id ]) }}" method="post">
                @csrf
                <input type="submit" value="{{ isset($user->is_active) && $user->is_active ?  "Inactive" : "Active" }}">
            </form>
        </div>
    </div>
</div>
@endsection
