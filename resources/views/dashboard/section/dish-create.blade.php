@extends('dashboard.dashboard')

@section('dashboardSection')
    <h1 class="text-center fw-bold p-3">
        CREATE A NEW DISH
    </h1>

    <div class="create" id="dish-create">
        <form method="POST" action="{{ route('dish.store') }}" enctype="multipart/form-data">

            @csrf
            @method('POST')
            <div class="m-4">
                <label for="dish_name">Name</label>
                <input type="text" required minlength="2" maxlength="64" name="dish_name" id="dish_name">
                @error('dish_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="m-4">
                <label for="description">Description</label>
                <input type="text" maxlength="1275" name="description" id="description">
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="m-4">
                <label for="price">Price</label>
                <input type="number" required step="any" min="0.00" name="price" id="price">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="m-4">
                <label for="img">Imagine</label>
                <input type="file" maxlength="255" name="img" id="img">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="m-4">
                <label for="visibility">Visibility</label>
                <select name="visibility" required id="visibility">
                    <option value="1">Visible</option>
                    <option value="0">Not Visible</option>
                </select>
            </div>
            <div class="text-center">
                <input id="crea" class="m-3 px-3 py-1" type="submit" value="Create">
            </div>
        </form>
    </div>
@endsection
