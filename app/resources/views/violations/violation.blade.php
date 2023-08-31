@extends('layouts.app')
@section('content')
<div class="container">
    <h1>違反報告・コメント</h1>
    <form action="{{route('violations.store')}}" method="post" enctype="multipart/form-data" >
    @csrf
      <div class="mb-3">
      <input type="hidden" name="post_id" value="{{$test}}">
        <textarea name="text" id="text" class="form-control" value="{{ old('text')  }}" rows="3"></textarea>
</div>
        <button type="submit"  class="btn btn-primary">報告する</button>
        <button type="reset"  class="btn btn-secondary" onclick='window.history.back(-1);'>キャンセル</button>
    </form>
</div>
@endsection