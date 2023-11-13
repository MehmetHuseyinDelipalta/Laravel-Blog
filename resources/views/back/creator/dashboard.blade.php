@extends('back.creator.layouts.master')
@section('title', 'Creator Dashboard')
@section('content')
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-3 mb-3">
            <div class="card border-left-primary shadow py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Article</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $articlesCountUser }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-3 mb-3">
            <div class="card border-left-success shadow py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Vote Count Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $voteCountUser }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-3 mb-3">
            <div class="card border-left-warning shadow py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Most Voted Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('admin.article.edit', $mostUserVotedTodayArticleId) }}">
                                    {{ $mostUserVotedTodayArticleName . ' (' . $mostUserVotedTodayVoteCount . ')' }}
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Last 10 Articles</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Creator</th>
                                <th>Create Date</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lastTenArticleUser as $row)
                                <tr>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->getCreator->name }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <a href="{{ route('single', $row->slug) }}" title="Preview" target="_blank"
                                            class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('creator.article.edit', $row->id) }}" title="Edit"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('creator.delete.article', $row->id) }}" title="Delete"
                                            class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
