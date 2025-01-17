<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumes</title>
</head>
<body>
    <h1>Resumes</h1>

    @if($resumes->isEmpty())
        <p>No resumes available.</p>
    @else
        <ul>
            @foreach($resumes as $resume)
                <li>
                    <h2>{{ $resume->title }}</h2>
                    <p>{{ $resume->content }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
