<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Emails</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estagios as $estagio)
        <tr>
            <td>{{ $estagio['idestagio'] }}</td>
            <td>{{ $estagio['tituloestagio'] }}</td>
            <td>{{ implode(', ', $estagio['emails']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>