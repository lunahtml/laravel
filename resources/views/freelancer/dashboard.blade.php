<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/skills.js') }}" defer></script>
</head>
<body>
    <h1>Welcome to your Freelancer Dashboard</h1>
    <p>Hello, {{ auth()->user()->name }}!</p>
    <p>Email: {{ auth()->user()->email }}</p>
    <p>Role: {{ auth()->user()->role }}</p>
    <p>Categories:</p>
<ul>
    @foreach(auth()->user()->resumes->flatMap->categories->unique('id') as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

<p>Skills:</p>
<ul>
    @foreach(auth()->user()->resumes->flatMap->skills->unique('id') as $skill)
        <li>{{ $skill->name }}</li>
    @endforeach
</ul>


    <h2>Your Resumes</h2>
    <ul>
    @foreach($resumes as $resume)
        <li>
            <strong>{{ $resume->title }}</strong> - {{ $resume->status }}
            @if($resume->file_path)
                <br>
                <a href="{{ asset('storage/' . $resume->file_path) }}" target="_blank">Download File</a>
            @endif
            <br>
            <a href="{{ route('freelancer.resume.edit', $resume->id) }}">Edit</a>
        </li>
    @endforeach
</ul>


    <h3>Create a New Resume</h3>
    <h1>Create a Resume</h1>
    <form method="POST" action="{{ route('freelancer.resume.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="5" required></textarea>
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    <div>
        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file">
    </div>
    <div>
    <label for="category">Category:</label>
    <select id="category" name="category" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="skills">Skills:</label>
    <input type="text" id="skill_input" placeholder="Enter a skill">
    <div id="skill_suggestions"></div>
    <div id="selected_skills"></div>
    <input type="hidden" id="skills_input" name="skills">
</div>
    <button type="submit">Create</button>
</form>

</body>
</html>
