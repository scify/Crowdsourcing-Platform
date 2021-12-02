<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }}
        <i class="fas fa-caret-down"></i>
    </a>

    <ul class="dropdown-menu">
        @foreach (config('app.available_locales') as $key => $label)
            <li>
                <a class="dropdown-item"
                   href="{{ route( getNameOfRoute(\Illuminate\Support\Facades\Route::current()),
                                                   SetParameterAndGetAll(\Illuminate\Support\Facades\Route::current(), "locale", $key)) . getRouteParameters()
                                            }}"
                   @if (app()->getLocale() == $key) style="font-weight: bold; text-decoration: underline" @endif>{{ strtoupper($key) . ", ".strtoupper($label) }}</a>
            </li>
        @endforeach
    </ul>
</li>
