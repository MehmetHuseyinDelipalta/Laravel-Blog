@extends('front.layouts.master')
@section('title', $article->title)
@section('bg', asset($article->image))
@section('content')
    <!-- Post Content-->
    <article class="mb-12">
        <div class="container px-12 px-lg-12">
            <div class="row gx-12 gx-lg-12 justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="col-example">
                @if ($article->getPrev())
                    <a href="{{ route('single', [$article->getPrev()->slug]) }}" class="btn btn-primary">
                        &larr;
                        @if (strlen($article->getPrev()->title) > 20)
                            {{ substr($article->getPrev()->title, 0, 20) . '...' }}
                        @else
                            {{ $article->getPrev()->title }}
                        @endif
                    </a>
                @endif
            </div>
            <div class="col-example">
                <fieldset class="rating">
                    <legend>Please rate:</legend>

                    @php
                        $votes = $article->getUpdatedVoteAverage(); // Oyları bir değişkende saklayalım
                    @endphp

                    @foreach (range(1, 5) as $rate)
                        <span class="fa fa-star {{ $votes >= $rate ? 'vote-checked' : '' }}" data-rate="{{ $rate }}"
                            onclick="votes({{ $article->id }}, {{ $rate }})"></span>
                    @endforeach
                </fieldset>

            </div>
            <div class="col-example">
                @if ($article->getNext())
                    <a href="{{ route('single', [$article->getNext()->slug]) }}" class="btn btn-primary">
                        @if (strlen($article->getNext()->title) > 20)
                            {{ substr($article->getNext()->title, 0, 20) . '...' }}
                        @else
                            {{ $article->getNext()->title }}
                        @endif &rarr;
                    </a>
                @endif
            </div>
        </div>
    </article>
@endsection
@section('css')
    <link href="{{ asset('front/') }}/css/custom.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function votes(article_id, rate) {
            $.ajax({
                type: "POST",
                url: "{{ route('vote') }}",
                data: {
                    article_id: article_id,
                    rate: rate,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (data.status === 'success') {
                        $('.rating').find('.vote-checked').removeClass('vote-checked');
                        for (let i = 1; i <= Math.floor(data.rate); i++) {
                            $('.rating').find('[data-rate="' + i + '"]').addClass('vote-checked');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 403) {
                        Swal.fire({
                            icon: xhr.responseJSON.status,
                            title: xhr.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        }
    </script>
@endsection
