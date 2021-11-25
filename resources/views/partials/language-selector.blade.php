<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }}
        <i class="fas fa-caret-down"></i>
    </a>

    <ul class="dropdown-menu">
        @foreach (config('app.available_locales') as $key => $label)
            <li >
                <a class="dropdown-item"
                                   href="{{route(\Illuminate\Support\Facades\Route::current()->getName(),["locale"=>$key])}}"
                   @if (app()->getLocale() == $key) style="font-weight: bold; text-decoration: underline" @endif>{{ strtoupper($key) . ", ".strtoupper($label) }}</a>
            </li>
        @endforeach
    </ul>
</li>
