@extends('template')
@section('content')
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6">

            <form action="{{route('books.store')}}" method='post' style="display:flex;flex-direction: column;">
                @csrf
                <div>
                    <label for="author">Choose author:</label>
                    <select name="author" id="author">
                        @foreach ($authors as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title">Title:</label>
                    <input style='border: 1px solid black!important;' type="text" name="title" id="title">
                </div>
                <div>
                    <label for="release_date">Release date:</label>
                    <input style='border: 1px solid black!important;' type="date" name="release_date" id="release_date">
                </div>
                <div>
                    <label for="description">Description:</label> <br>
                    <textarea style='border: 1px solid black!important;' name="description" id="description" rows="5"></textarea>
                </div>
                <div>
                    <label for="isbn">ISBN:</label>
                    <input style='border: 1px solid black!important;' type="text" name="isbn" id="isbn">
                </div>
                <div>
                    <label for="format">Format:</label>
                    <input style='border: 1px solid black!important;' type="text" name="format" id="format">
                </div>
                <div>
                    <label for="number_of_pages">Pages:</label>
                    <input style='border: 1px solid black!important;' type="number" name="number_of_pages" id="number_of_pages">
                </div>

                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</div>

@endsection