<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>
    <div class="container py-5">
        <h1 class="mb-4">Testgegevens</h1>

        @if ($tests->isEmpty())
            <div class="alert alert-info">
                Er zijn nog geen testgegevens.
            </div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Omschrijving</th>
                        <th>Actief</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tests as $test)
                        <tr>
                            <td>{{ $test->id }}</td>
                            <td>{{ $test->naam }}</td>
                            <td>{{ $test->omschrijving }}</td>
                            <td>
                                @if ($test->actief)
                                    <span class="badge bg-success">Ja</span>
                                @else
                                    <span class="badge bg-secondary">Nee</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>