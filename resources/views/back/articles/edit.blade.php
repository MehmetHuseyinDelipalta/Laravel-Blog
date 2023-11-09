@extends('back.layouts.master')
@section('title', 'Article Edit')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title') </h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li> {{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form method="post" action="{{ route('article.update', $article->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" required value="{{ $article->title }}" />
                </div>
                <div class="form-group">
                    <label>Article Picture</label>
                    <input type="file" class="form-control" name="image" />
                    @if ($article->image)
                        <br>
                        <img src="{{ asset($article->image) }}" style="width: 100px; height: 100px;" class="img-thumbnail"
                            alt="{{ $article->title }}">
                    @endif
                </div>
                <div class="form-group">
                    <label>Article Text</label>
                    <textarea id="editor" class="form-control" name="content" required>{{ $article->content }}</textarea>
                </div>
                <div class="form-group">
                    <label>Publish Date</label>
                    <input type="date" class="form-control" name="publish_date" required
                        value="{{ $article->publish_date ? \Carbon\Carbon::parse($article->publish_date)->format('Y-m-d') : now()->format('Y-m-d') }}" />
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option @if ($article->status == 'draft') selected @endif value="draft">Draft</option>
                        <option @if ($article->status == 'active') selected @endif value="active">Active</option>
                        <option @if ($article->status == 'passive') selected @endif value="passive">Passive</option>
                    </select>
                </div>
                <div class="form-group float-left">
                    <button button type="submit" class="btn btn-primary btn-block">Updated Article</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <!-- include summernote css/js -->

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                'height': 300
            });

        });
    </script>
@endsection
