<nav class="navbar navbar-expand-lg sticky-top bg-white"
    style="padding-left: var(--navbar-content-padding-value-left); padding-right: calc(var(--navbar-content-padding-value-right)*0.5)">
    <div class="container-fluid" style="padding-left: 0">
        <a class="navbar-brand text-primary font-size-menu " href="{{ route('home') }}"><!-- 
			--><span class="fw-menu font-dei-grotesk">e</span><!--
			--><span class="fw-menu font-dei-variable-reg">s</span><!--
			--><span class="fw-menu font-dei-grotesk">t</span><!--
			--><span class="fw-menu font-dei-grotesk">á</span><!--
			--><span class="fw-menu font-dei-variable-light">g</span><!--
			--><span class="fw-menu font-dei-variable-reg">i</span><!--
			--><span class="fw-menu font-dei-grotesk">o</span><!--
			--><span class="fw-menu font-dei-variable-light">s</span><!--
			-->
        </a>
        <button class="navbar-toggler btn btn-link" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"
            style="border: none !important; outline: 0; border-color: white !important">
            <i class="bi bi-list text-primary" style="font-size: 2.5rem"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @foreach ($navbaritems as $item)
                    <li class="nav-item dei-items">
						<a class="nav-link  text-primary"
							aria-current="page" href="{{ route($item['route']) }}"><span @if ($item['active'] ) class="active " @endif>{{ $item['name'] }}</span></a>
                    </li>
                @endforeach
                {{-- <li class="nav-item dei-items">
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas"
                        aria-controls="offcanvas"
                  >
                      
                </li> --}}
            </ul>
            <div class="dei-items" style="display: block">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                @if(App\Http\Controllers\Auth\Authentication::check())
                    <li class="nav-item dei-items" style="margin-bottom: var(--margin-shrunk-bottom); margin-left: var(--margin-shrunk-sides); display: var(--name-hidden); margin-right: 0.5rem !important">
                        <span class="">{{session()->get('user')->getShortName()}}</span>
                    </li>
                    <li class="nav-item dei-items dropstart" >
                        <a  class="nav-link text-primary" 
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            data-bs-display="static"
                            style="display: inline; margin-left: var(--margin-shrunk-sides) !important; margin-right: 0.5rem">
                                <span class="active"><!--
                                    -->{{trans_choice('words.roles.short.'.session()->get('activeRole'),1)}}<!--
                             --></span>
                        </a>
                        @if(count(session()->get('roles')) > 1)
                            <ul class="dropdown-menu dropdown-menu-start " style="text-transform: none"> 
                                @php
                                    $activeRole = session()->get('activeRole');
                                @endphp
                                @foreach (session()->get('user')->rolesExcept($activeRole) as $role)
                                    @if($role->tipo != $activeRole)
                                        <li><a class="dropdown-item" href="{{route('switch.role',$role->tipo)}}">{{trans_choice('words.roles.short.'.$role->tipo,1)}}</a></li>
                                        @if(!$loop->last)
                                            <li><hr class="dropdown-divider"></li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{route('logout')}}" style="margin-left: 0rem"><i class="bi bi-x-lg" ></i></a>
                        
                    </li>

                    <li class="nav-item dei-items">
                    </li>
                @else
                    <a class="nav-link text-primary" href="{{ route('login') }}">{{ __('words.login') }}</a>
                @endif
                </ul>
            </div>
        </div>


    </div>
</nav>
