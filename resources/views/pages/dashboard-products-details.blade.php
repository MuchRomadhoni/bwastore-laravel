@extends('layouts.admin')

@section('title')
    Store Dashboard Product Detail
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ $products->name }}</h2>
                <p class="dashboard-subtitle">
                    Product Details
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('dashboard-product-update', $products->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Product Name</label>
                                                <input type="text" class="form-control" id="name"
                                                    aria-describedby="name" name="name" value="{{ $products->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="number" class="form-control" id="price"
                                                    aria-describedby="price" name="price"
                                                    value="{{ $products->price }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori Product</label>
                                                <select name="categories_id" class="form-control">
                                                    <option value="{{ $products->categories_id }}">Tidak Diganti
                                                        ({{ $products->category->name }})</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="4" class="form-control">{!! $products->description !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-block px-5">
                                                Update Product
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($products->galleries as $gallery)
                                        <div class="col-md-4">
                                            <div class="gallery-container">
                                                <img src="{{ Storage::url($gallery->photos ?? '') }}" alt=""
                                                    class="w-100" />
                                                <a class="delete-gallery"
                                                    href="{{ route('dashboard-product-gallery-delete', $gallery->id) }}">
                                                    <img src="/images/icon-delete.svg" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-12 mt-3">
                                        <form action="{{ route('dashboard-product-gallery-upload') }}"
                                            enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <input type="hidden" name="products_id" value="{{ $products->id }}">
                                            <input type="file" name="photos" id="file" style="display: none;"
                                                onchange="form.submit()" multiple />
                                            <button type="button" class="btn btn-secondary btn-block"
                                                onclick="thisFileUpload();">
                                                Add Photo
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        function thisFileUpload() {
            document.getElementById("file").click();
        }
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
