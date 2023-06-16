@foreach ($data as $row)
    <option value="{{ $row['id'] }}"
            @if($row['id'] == $selectedValue) selected @endif
    >{{ $row[$fieldName]}}</option>
@endforeach