<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Alumni 1</title>
</head>
<body>
    <h1>Register Alumni</h1>
    <form action="{{ route('alumni.register') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="major_id">Major ID</label>
            <input type="text" id="major_id" name="major_id" value="{{ old('major_id') }}" required>
        </div>
        <div>
            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required>
        </div>
        <button type="submit">Register</button>
    </form>

</body>
</html>
