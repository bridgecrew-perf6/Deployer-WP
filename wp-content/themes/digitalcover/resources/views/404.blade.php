@extends('layouts.app')

@section('content')
  <div data-router-view="page" data-id={{ get_the_ID() }}>
    <div class="p404">
      <div class="container">
        <div class="col-xl-10 m-auto">
          <h1 class="p404__title">404</h1>
          <p class="p404__desc">{{ __('Page non trouvée', 'fullajax') }}</p>
          <div class="p404__btn">
            <a href="{{ get_bloginfo('url') }}">{{ __('Retour à l\'accueil', 'digitalcover') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
