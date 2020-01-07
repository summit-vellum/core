<div class="bg-gray-800 w-64 fixed inset-y-0 left-0 w-8 bg-gray-700 p-5">
    <div class="p-2 block text-center mb-10">
        <img class="inline-block" src="{{ asset('images/summit-bw.svg') }}" width="100" height="100" alt="Summit Media Digital">
    </div>

    <div class="mb-10">
        <h5 class="mb-3 font-bold text-sm uppercase tracking-widest text-gray-500">Modules</h5>

        @foreach($modules as $module)
            @if(Auth::user()->modules()->contains($module['name']))
            <a href="{{ route($module['name'].'.index') }}" class="flex item-center mx-2 px-2 py-1 font-medium text-gray-100 hover:text-gray-300">
                {!! $module['icon'] !!}
                <span class="ml-3">{{ $module['title'] }}</span>
            </a>
            @endif
        @endforeach
    </div>
 
 
    @if(isset($settings) && count($settings))

    <div class="mb-10">
        <h5 class="mb-3 font-bold text-sm uppercase tracking-widest text-gray-500">Settings</h5>
        <a href="#" class="flex item-center mx-2 px-2 py-1 font-medium text-gray-100 hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current"><path class="heroicon-ui" d="M18 21H7a4 4 0 0 1-4-4V5c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2h2a2 2 0 0 1 2 2v11a3 3 0 0 1-3 3zm-3-3V5H5v12c0 1.1.9 2 2 2h8.17a3 3 0 0 1-.17-1zm-7-3h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 1 1 0-2zm9 11a1 1 0 0 0 2 0V7h-2v11z"/></svg>
            <span class="ml-3">Posts</span>
        </a>
        <a href="#" class="flex item-center mx-2 px-2 py-1 font-medium text-gray-100 hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current"><path class="heroicon-ui" d="M18 21H7a4 4 0 0 1-4-4V5c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2h2a2 2 0 0 1 2 2v11a3 3 0 0 1-3 3zm-3-3V5H5v12c0 1.1.9 2 2 2h8.17a3 3 0 0 1-.17-1zm-7-3h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 1 1 0-2zm9 11a1 1 0 0 0 2 0V7h-2v11z"/></svg>
            <span class="ml-3">Sections</span>
        </a>
    </div>

    @endif

</div>
