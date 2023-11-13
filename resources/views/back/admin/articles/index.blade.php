@extends('back.admin.layouts.master')
@section('title', 'All Articles')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title') {{ $articles->count() }} article found. </h6>
            <a href="{{ route('admin.trash.article') }}" class="btn btn-primary btn-sm float-right"><i
                    class="fa fa-trash"></i>Trash</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Create Date</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td><img src="{{ asset($article->image) }}" width="200" /></td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->getCreator->name }}</td>
                                <td>{{ $article->created_at }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $article->status == 'passive' ? 'danger' : 'success' }}">{{ $article->status == 'passive' ? 'Passive' : 'Active' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('single', $article->slug) }}" title="Preview" target="_blank"
                                        class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.article.edit', $article->id) }}" title="Edit"
                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.delete.article', $article->id) }}" title="Delete"
                                        class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
