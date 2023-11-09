@extends('back.layouts.master')
@section('title', 'Article Create')
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
            <form method="post" action="{{ route('article.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" required />
                </div>
                <div class="form-group">
                    <label>Article Picture</label>
                    <input type="file" class="form-control" name="image" required />
                </div>
                <div class="form-group">
                    <label>Article Text</label>
                    <textarea id="editor" type="text" class="form-control" name="content" required></textarea>
                </div>
                <div class="form-group">
                    <label>Publish Date</label>
                    <input type="date" class="form-control" name="publish_date" required />
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="passive">Passive</option>
                    </select>
                </div>
                <div class="form-group float-right">
                    <button button type="submit" class="btn btn-primary btn-block">Add Article</button>
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
