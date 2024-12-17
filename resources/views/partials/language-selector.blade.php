@php use Illuminate\Support\Facades\Route; @endphp
<li class="nav-item dropdown language-selector">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }}
        <i class="fas fa-caret-down"></i>
    </a>

    <ul class="dropdown-menu">
        @foreach($languages as $language)
            <form id="set-locale-{{$language->language_code}}" action="{{route('languages.setlocale', ['locale' => $language->language_code])}}" method="POST"
                  style="display: none;">
                @csrf
                <input type="hidden" name="locale" value="{{$language->language_code}}">
            </form>
            <a class="dropdown-item" href="#"
               @if (app()->getLocale() == $language->language_code) style="font-weight: bold; text-decoration: underline" @endif
               onclick="event.preventDefault(); document.getElementById('set-locale-{{$language->language_code}}').submit();">
                {{$language->language_name}}
            </a>
        @endforeach
    </ul>
</li>
