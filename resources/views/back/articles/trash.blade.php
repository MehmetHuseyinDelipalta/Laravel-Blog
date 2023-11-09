@extends('back.layouts.master')
@section('title', 'All Trash Articles')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title') {{ $articles->count() }} article found. </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Deleted Date</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td><img src="{{ asset($article->image) }}" width="200" /></td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->getCreator->name }}</td>
                                <td>{{ $article->deleted_at }}</td>
                                <td>
                                    <a href="{{ route('admin.recover.article', $article->id) }}" title="Back"
                                        class="btn btn-primary btn-sm"><i class="fa fa-recycle"></i> Back</a>
                                    <a href="{{ route('admin.forceDelete.article', $article->id) }}" title="Delete"
                                        class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
