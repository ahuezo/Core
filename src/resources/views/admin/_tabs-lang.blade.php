@if (count($locales) > 1)
<ul class="nav nav-tabs" id="locale-changer">
    @foreach ($locales as $lang)
    <li class="@if ($lang == $locale)active @endif">
        <a href="#{{ $lang }}" data-target="#{{ $lang }}" data-locale="{{ $lang }}" data-toggle="tab">@lang('global.languages.'.$lang)</a>
    </li>
    @endforeach
</ul>
@endif
