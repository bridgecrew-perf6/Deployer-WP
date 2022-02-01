@extends('layouts.app')

@section('content')
  @while (have_posts()) @php the_post() @endphp
    <div data-router-view="page">
      <div class="home">
        <h1>{{ __('Hello World!', 'digitalcover') }}</h1>
        <a href="http://starter-dc.localhost/a-propos">Link</a>
        {!! the_content() !!}
      </div>
    </div>
  @endwhile
@endsection
