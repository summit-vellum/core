<nav class="navbar navbar-default navbar-fixed-top navbar-main">
    <div class="container-fluid">
        <div class="navbar-header">
        	<ul class="navbar-brand mb-0">
                <div class="dropdown">
                    <div class="site-logo-container dropdown-toggle hide-mobile" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background:{{ $site['color'] }}" onClick="location.href='/'" title="Exit This Page">
                    	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="display: none;">
	        				<style>.svg-white{fill-rule:evenodd;clip-rule:evenodd;fill:#ffffff}</style>
	        				 <symbol id="topgear-logo" viewBox="0 0 48 48"><path class="svg-white" d="M13.1 33.2l8.2-20.4h6.5l2.4-6.1H7.6l-2.4 6.1h6.5L3.6 33.2h9.5zM35 22.9h9c2.1-5.2 1.4-8.8-8.1-8.8-11.7 0-12.9 1.7-17.6 13.6-3 7.4-5 13.5 4.7 13.5 4.4 0 5.6-.3 8.1-2.6h.1l-.6 2.1h6.7l5.6-14.2H31.2l-1.9 4.8H32l-.7 1.7c-.7 1.9-1.7 3.3-4 3.3s-1.7-1.9-1.1-3.5l4.2-10.7c.6-1.6 1.4-3.2 3.7-3.2 1.9 0 2.1 1 1.2 3l-.3 1z"/></symbol>
	        			</svg>
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
