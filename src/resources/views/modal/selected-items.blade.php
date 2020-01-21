<div class="border relative border-gray-400 py-2 pl-2 pr-12 m-2 h-auto flex-item flex-auto border-dashed w-1/4" data-selected-item>

	<a href="#" class="absolute inline-block top-0 right-0 bg-red-300 hover:bg-red-500 text-white p-2 text-xs">
		@icon(['icon' => 'trash'])
	</a>

	<span class="text-sm text-gray-500">{{ $data->section ?? 'Section'}}</span>
	<div class="font-bold leading-tight">{{ $data->title ?? 'Title'}}</div>
	<span class="text-sm text-gray-700">{{ $data->publish_at ?? 'Date Publish'}}</span>
</div>
