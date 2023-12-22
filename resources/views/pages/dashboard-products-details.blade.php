@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product Detail
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Shirup Marzan</h2>
                <p class="dashboard-subtitle">
                    Product Details
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <form action="">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Product Name</label>
                                                <input type="text" class="form-control" id="name"
                                                    aria-describedby="name" name="storeName" value="Papel La Casa" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="number" class="form-control" id="price"
                                                    aria-describedby="price" name="price" value="200" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
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
                                    <div class="col-md-4">
                                        <div class="gallery-container">
                                            <img src="/images/product-card-1.png" alt="" class="w-100" />
                                            <a class="delete-gallery" href="#">
                                                <img src="/images/icon-delete.svg" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="gallery-container">
                                            <img src="/images/product-card-2.png" alt="" class="w-100" />
                                            <a class="delete-gallery" href="#">
                                                <img src="/images/icon-delete.svg" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="gallery-container">
                                            <img src="/images/product-card-3.png" alt="" class="w-100" />
                                            <a class="delete-gallery" href="#">
                                                <img src="/images/icon-delete.svg" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col mt-3">
                                        <input type="file" id="file" style="display: none;" multiple />
                                        <button class="btn btn-secondary btn-block" onclick="thisFileUpload();">
                                            Add Photo
                                        </button>
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
