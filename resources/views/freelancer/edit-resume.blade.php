<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume</title>
</head>
<body>
    <h1>Edit Resume</h1>

    <form method="POST" action="{{ route('freelancer.resume.update', $resume->id) }}">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $resume->title }}" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required>{{ $resume->content }}</textarea>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="draft" {{ $resume->status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $resume->status === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
