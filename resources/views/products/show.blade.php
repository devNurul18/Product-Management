@extends('layout.app')

@section('title' , 'Product Details')

@section('content')
<div class="container mt-4">
    <h1>Product Details</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Image:</strong></p>
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 300px;">

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
