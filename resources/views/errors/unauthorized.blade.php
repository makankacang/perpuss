<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <div>
        <p>{{ $message }}</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = '/';
        }, 5000); // Redirect after 5 seconds
    </script>
</body>
</html>
