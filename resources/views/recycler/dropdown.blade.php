@foreach ($data as $row)
    <option value="{{ $row['id'] }}" @selected($row['id'] == $selectedValue)>{{ $row[$fieldName]}}</option>
@endforeach
