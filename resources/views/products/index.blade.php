@extends('layout.app')

@section('title', 'All Products')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Products</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Search Form -->
        <form method="GET" action="{{ route('products.index') }}" class="d-flex flex-grow-1 me-3">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by ID, Name, Description, or Price..." 
                class="form-control me-2" 
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        
        <!-- Add Product Button -->
        <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
    </div>

    <!-- Product Table -->
    <table class="table table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Product ID</th>
                <th>
                    <a href="?sort_by=name&order={{ request('order') === 'asc' ? 'desc' : 'asc' }}" class="text-white">
                        Name
                        @if(request('sort_by') === 'name')
                            <i class="ms-1 bi bi-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th>Description</th>
                <th>
                    <a href="?sort_by=price&order={{ request('order') === 'asc' ? 'desc' : 'asc' }}" class="text-white">
                        Price
                        @if(request('sort_by') === 'price')
                            <i class="ms-1 bi bi-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="80" class="img-thumbnail">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" alt="No Image" width="80" class="img-thumbnail">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
