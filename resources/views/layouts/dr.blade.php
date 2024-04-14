@include('partials.languageSwitcher')

<!-- this should be written in master.blade.php if we want to change the complete html code in dr for example-->


@if(session('locale') == 'en')
    @include('layouts.en')
@endif

@if(session('locale') == 'dr')
    @include('layouts.dr')
@endif