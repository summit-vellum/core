@isset($data)

@if(array_key_exists('relation', $attributes))

@if(array_key_exists('modify', $attributes))
@if(isHTML(call_user_func_array($attributes['modify'], [
$data->getRelationshipObject($attributes['relation']),
$data
])))
{!! call_user_func_array($attributes['modify'], [
$data->getRelationshipObject($attributes['relation']),
$data
]) !!}
@else
{{ call_user_func_array($attributes['modify'], [
$data->getRelationshipObject($attributes['relation']),
$data
]) }}
@endif
@else
{!! $data->getRelationshipProperty($attributes['relation']) !!}
@endif

@else

@if(array_key_exists('modify', $attributes))
{!!call_user_func_array($attributes['modify'], [$data])!!}
@else

@if(isset($key) && !is_null($data->{$key}))
{!!$data->{$attributes['id']}!!}
@else
{!!isset($attributes['columns']) ? $data->{$attributes['columns']} : ''!!}
@endif

@endif

@endif

@endif

