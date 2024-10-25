@php
    // var_dump($viewModel);
@endphp

<ol>
    @foreach ($viewModel['problems'] as $problem)
        <li>
            id: {{ $problem->id }} <br>
            slug: {{ $problem->slug }} <br>
            default_language_id: {{ $problem->default_language_id }} <br>
            @foreach ($problem->translations as $translation)
                @if ($translation->language_id === $problem->default_language_id)                    
                    default_lang_title: {{ $translation->title }} <br>
                    default_lang_desc: {{ $translation->description }} <br>
                @endif
            @endforeach
        </li>
        <hr>
    @endforeach
</ol>
