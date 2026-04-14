<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background: #f4f4f4; }
        .gallery { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 30px; }
        .card { background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        img { max-width: 300px; border-radius: 4px; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; margin-bottom: 20px; }
        input, button { display: block; margin-bottom: 15px; width: 100%; padding: 8px;}
    </style>
</head>
<body>

    <h1>📸 My Gallery</h1>

    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Upload</button>
    </form>

    <hr>

    <div class="gallery">
        @foreach($photos as $photo)
        <div class="card">
            <img src="{{ $photo->file_path }}" alt="{{ $photo->title }}">
            <p>{{ $photo->title }}</p>
            <form action="/delete/{{ $photo->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
        @endforeach
    </div>

    

    </body>
</html>