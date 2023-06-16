@foreach ($data as $row)
    <option value="{{ $row['id'] }}"
{{--            {{ old($old, $default) == $row['id'] ? 'selected' : '' }}--}}
            {{ old($old, $default) == $row['id'] ? 'selected' : '' }}

    >{{ $row[$fieldName]}}</option>
@endforeach