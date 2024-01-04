<style type="text/css">
    table tr td,
    table tr th {
        font-size: 9pt;
    }
</style>


<table class='table table-bordered'>
    <thead>
        <tr>
            <th>No</th>
            <th>{{ __('Name') }}</th>
            @foreach ($criterias as $criteria)
                <th scope="col">
                    {{ 'C' . $loop->index + 1 }}

                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($matrix as $data)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td> {{ $data['name'] }} </td>
                @foreach ($data['values'] as $data)
                    <td>{{ $data }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
