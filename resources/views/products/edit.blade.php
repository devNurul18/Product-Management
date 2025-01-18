@extends('layout.app')

@section('title' , 'Edit Product')

@section('content')
<div class="container mt-4">
    <h1>Edit Product</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="product_id" name="product_id" 
                   value="{{ $product->product_id }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" 
                   value="{{ $product->price }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" 
                   value="{{ $product->stock }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <p>Current Image:</p>
            <img src="{{ Storage::url($product->image) }}" alt="Image" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
