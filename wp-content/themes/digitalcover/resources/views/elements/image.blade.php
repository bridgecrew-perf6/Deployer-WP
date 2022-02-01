<div class="image @if($data['class']){{ $data['class'] }}@endif">
  <picture>
    <source
      type="image/webp"
      media="(min-width : 300px)"
      @if (!$data['no-lazy'])
        data-srcset="
          @foreach($data['srcset'] as $key => $value)
            {{ $value . ' ' . $key }},
          @endforeach
        "
        data-sizes="(max-width: 1023px) {{ $data['max-width-mobile'] }}, {{ $data['max-width'] }}"
      @else
        srcset="
          @foreach($data['srcset'] as $key => $value)
            {{ $value . ' ' . $key }},
          @endforeach
        "
        sizes="(max-width: 1023px) {{ $data['max-width-mobile'] }}, {{ $data['max-width'] }}"
      @endif
    />
    <img
      class="@if(!$data['no-lazy']){{ 'lazy' }}@endif {{ $data['class'] }}"
      width="150"
      height="150"
      alt="{{ $data['alt'] }}"
      @if (!$data['no-lazy'])
        src="{{ get_template_directory_uri() . "/assets/images/svg/loader.svg" }}"
        data-src="{{ $data['url-low-quality'] }}"
        data-srcset="
          @foreach($data['srcset'] as $key => $value)
            {{ $value . ' ' . $key }},
          @endforeach
        "
      @else
        src="{{ $data['url-low-quality'] }}"
        alt="{{ $data['alt'] }}"
        srcset="
          @foreach($data['srcset'] as $key => $value)
            {{ $value . ' ' . $key }},
          @endforeach
        "
      @endif
      data-sizes="(max-width: 1023px) {{ $data['max-width-mobile'] }}, {{ $data['max-width'] }}"
    >
  </picture>
</div>
