@extends('front.layouts.master')
@section('title', 'Homepage')
@section('content')
    <!-- Main Content-->
    <div class="col-md-12 col-lg-12 col-xl-12">
        @foreach ($articles as $article)
            <!-- Post preview-->
            <div class="post-preview">
                <a href="{{ 'blog/' . $article->slug }}">
                    <img src="{{ $article->image }}" alt="{{ $article->title }}" class="img-fluid">
                    <h2 class="post-title">{{ $article->title }}</h2>
                    <h3 class="post-subtitle">
                        {{ mb_strlen($article->content) > 100 ? mb_substr($article->content, 0, 100) . '...' : $article->content }}
                    </h3>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#!">{{ $article->getCreator->name }}</a>
                    <!-- $article->creator->name kullanarak ilişkili kullanıcının adını alın -->
                    on {{ $article->created_at->diffForHumans() }}
                </p>
            </div>
            @if (!$loop->last)
                <!-- Divider-->
                <hr class="my-4" />
            @endif
        @endforeach
        <!-- Sayfalama için gerekli kod, bootstrap ile uyumlu, sayfanın tam ortasında görüntülenir -->
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
