<nav class="navbar navbar-default navbar-fixed-top navbar-main">
    <div class="container-fluid">
        <div class="navbar-header">
        	<ul class="navbar-brand mb-0">
                <div class="dropdown">
                    <div class="site-logo-container dropdown-toggle hide-mobile" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background:{{ $site['color'] }}" onClick="location.href='/'" title="Exit This Page">
                    	@icon(['icon' => 'topgear-logo', 'isRaw' => true])
                        <svg class="site-logo dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background:{{$site['color']}}">
                                <use xlink:href="#{{$site['code_name']}}-logo"></use>
                        </svg>
                    </div>
                </div>
            </ul>
        </div>

        <div class="navbar-collapse collapse navbar-left">
        	<ul class="nav navbar-nav">
        		<li class="active"><a href=""><strong>Content</strong></a></li>
        		<li>
        			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Tools</strong></a>
        			<ul class="dropdown-menu mobile-dropdown-menu">
                        @foreach($modules as $module)
				            @if(Auth::user()->modules()->contains($module['name']))
				            <li><a href="{{ route($module['name'].'.index') }}">{{ $module['title'] }}</a></li>
                        	<li class="divider"></li>
				            @endif
				        @endforeach
        			</ul>
        		</li>
        	</ul>
        </div>

        <div id="navbar" class="navbar-collapse collapse navbar-right">
        	<ul class="nav navbar-nav">
			    @yield('actions')
        	</ul>
        </div>
    </div>
</nav>
