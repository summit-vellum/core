
@if(array_key_exists('relation', $attributes))

    @if(array_key_exists('modify', $attributes))

        {{ call_user_func_array($attributes['modify'], [
            $data->getRelationshipObject($attributes['relation']),
            $data
            ]) }}
    @else
        {{ $data->getRelationshipProperty($attributes['relation']) }}
    @endif

@else

    @if(array_key_exists('modify', $attributes))
        {{ call_user_func_array($attributes['modify'], [$data]) }}
    @else
        @if($data->{$key})
           {!! $data->{$attributes['id']} !!}
        @else
            {!! $data->{$attributes['columns']} !!}
        @endif
    @endif

@endif