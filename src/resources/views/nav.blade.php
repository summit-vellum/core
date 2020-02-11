<nav class="navbar navbar-default navbar-fixed-top navbar-main">
    <div class="container-fluid">
        <div class="navbar-header">
        	<ul class="navbar-brand mb-0">
                <div class="dropdown">
                    <div class="site-logo-container dropdown-toggle hide-mobile" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background:{{ $site['color'] }}" onClick="location.href='/'" title="Exit This Page">
                    	@if(isset($site['code_name']) && !empty($site['code_name'])) @icon(['icon' => $site['code_name'].'-logo', 'isRaw' => true]) @endif
                        <svg class="site-logo dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background:{{$site['color']}}">
                                <use xlink:href="#{{$site['code_name']}}-logo"></use>
                        </svg>
                    </div>
                </div>
            </ul>
        </div>

        <div class="navbar-collapse collapse navbar-left">
        	<ul class="nav navbar-nav">
        		<li class="active"><a href="@if(isset($site['main_module_slug'])) {{ url($site['main_module_slug']) }} @endif"><strong>Content</strong></a></li>
        		<li>
        			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Tools</strong></a>
        			<ul class="dropdown-menu mobile-dropdown-menu">
					@foreach(collect($modules)->where('parent', "") as $parent)
						@if(Auth::user()->modules()->contains($parent['name']))

						@if(collect($modules)->where('parent', $parent['name'])->count() <= 0)
						<li>
							<a href="{{ route($parent['name'].'.index') }}">{{ $parent['title'] }}</a>
						</li>
						@else
						<li class="dropdown-submenu">
							<a tabindex="-1" href="{{ route($parent['name'].'.index') }}" data-menu="bg" data-toggle="toggle">
								{{ $parent['title'] }}<span style="font-size:10px;margin-top:3px;float:right;" class="glyphicon glyphicon-triangle-right"></span>
							</a>
							<ul class="dropdown-menu"  style="left: 100%; margin-top: -40px; display: none;">
								@foreach(collect($modules)->where('parent', $parent['name']) as $child)
								<li><a href="{{ route($child['name'].'.index') }}" data-menu="bg">{{ $child['title'] }}</a></li>
								@endforeach
							</ul>
						</li>
						@endif

						@if(!$loop->last)
						<li class="divider"></li>
						@endif
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
