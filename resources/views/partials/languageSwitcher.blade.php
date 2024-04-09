@foreach($available_locales as $locale_name => $available_locale )

    @if($available_locale !== $current_locale)
         <li class="nav-item">
            <a class="nav-link" href="{{ route('localization', $available_locale) }}">{{$locale_name}}</a>
        </li>
    @endif

@endforeach