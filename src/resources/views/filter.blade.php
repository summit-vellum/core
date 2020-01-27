
@if(isset($filters))

<div class="float-right rounded border p-1 shadow bg-gray-100 relative">
    <input type="checkbox" value="1" class="hidden" id="filter">

    <label class="flex item-center relative cursor-pointer" for="filter">
        <span class="text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" class="fill-current"><path class="heroicon-ui" d="M2.3 7.7A1 1 0 0 1 2 7V3a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.3.7L15 14.42V17a1 1 0 0 1-.3.7l-4 4A1 1 0 0 1 9 21v-6.59l-6.7-6.7zM4 4v2.59l6.7 6.7a1 1 0 0 1 .3.71v4.59l2-2V14a1 1 0 0 1 .3-.7L20 6.58V4H4z"/></svg>
        </span>
        <span class="text-gray-700 inline-block" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" class="fill-current"><path class="heroicon-ui" d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"/></svg>
        </span>
    </label>

    <div class="w-64 absolute top-0 right-0 bg-white border p-5 shadow-lg filter-menu">


        @foreach($filters as $filter => $values)

        <div class="inline-block w-full relative w-64 mb-5">
          <select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" name="{{ $filter }}">
                <option value="0">-- Select {{ $filter }} --</option>
                @foreach($values as $id=>$value)
                    <option value="{{ $id }}"
                    @if(request($filter) == $id)
                    selected
                    @endif
                    >{{ $value }}</option>
                @endforeach
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
          </div>
        </div>

        @endforeach

        <div class="flex item-center">
            <label for="filter" class="flex-auto mr-1 rounded font-sm text-center font-semibold text-white bg-gray-500 px-4 py-2">Cancel</label>
            <button class="flex-auto ml-1 rounded font-sm font-semibold text-white bg-blue-500 px-4 py-2">Filter</button>
        </div>
    </div>
</div>

@endif
