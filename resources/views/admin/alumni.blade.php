<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Alumni</title>
</head>
<body>
    <h1>Data Alumni</h1>
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif
    <p>Welcome to the alumni data page!</p>
    {{-- table alumni name, email, major_id, nim, ambil data dri user_id name, email, photo--}}
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Major ID</th>
                <th>NIM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumni as $alumnus)
                <tr>
                    <td>{{ $alumnus->user->name }}</td>
                    <td>{{ $alumnus->user->email }}</td>
                    <td>{{ $alumnus->major_id }}</td>
                    <td>{{ $alumnus->nim }}</td>
                </tr>
            @endforeach
        </tbody>


</body>
</html>
