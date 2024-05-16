@extends('layouts.admin')

@section('title')
    List Users
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">List Users</h2>
                <p class="dashboard-subtitle">
                    List of Users
                </p>
            </div>
        </div>
    </div>

    <div class="dashboard-content p-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTableUsers">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTableUsers').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'roles', name: 'roles' },
                {
                    data: 'details',
                    name: 'details',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        });
    </script>
@endpush



