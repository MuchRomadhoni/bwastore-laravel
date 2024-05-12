@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">
                    Manage it well and get money
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('dashboard-product-create') }}" class="btn btn-success">Add New Product</a>
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            {{-- <div class="col"> --}}
                            <div class="component-products d-block bg-white p-3 rounded">
                                <div class="products-thumbnail" style="height: 200px">
                                    <div class="products-image"
                                        style=" @if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                @else
                                    background-color: #eee @endif">
                                    </div>
                                </div>
                                <div class="products-text text-truncate">
                                    {{ $product->name }}
                                </div>
                                <div class="products-price mb-2">
                                    {{ $product->category->name }}
                                </div>
                                <a class="btn btn-outline-success btn-block"
                                    href="{{ route('dashboard-product-details', $product->id) }}">
                                    Update
                                </a>
                                <a class="btn btn-outline-danger btn-block"
                                    href="{{ route('dashboard-product-delete', $product->id) }}">
                                    Delete
                                </a>
                            </div>
                            {{-- </div> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
