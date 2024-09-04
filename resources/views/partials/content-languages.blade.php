<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
        {{ app()->getLocale() }} <span class="caret"></span>
    </a>
    <div class="dropdown-menu" style="">
        @foreach($languages as $language)
            <form id="set-locale-{{$language->language_code}}" action="{{route('languages.setlocale')}}" method="POST"
                  style="display: none;">
                @csrf
                <input type="hidden" name="locale" value="{{$language->language_code}}">
            </form>
            <a class="dropdown-item" href="#"
               onclick="event.preventDefault(); document.getElementById('set-locale-{{$language->language_code}}').submit();">
                {{$language->language_name}}
            </a>
        @endforeach
    </div>
</li>