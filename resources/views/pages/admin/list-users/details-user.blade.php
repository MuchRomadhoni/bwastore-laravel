@extends('layouts.admin')

@section('title')
    List Users
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Details User</h2>
                <p class="dashboard-subtitle">
                    Details User
                </p>
            </div>
        </div>
    </div>
    <div class="dashboard-content p-4">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama User</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $item->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Roles</label>
                                    <input type="text" name="roles" class="form-control"
                                        value="{{ $item->roles }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email User</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $item->email }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaction</h2>
                <p class="dashboard-subtitle">
                    List of Transactions
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTableTransaction">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
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
        </div>
    </div>
@endSection

@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTableTransaction').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'total_price',
                    name: 'total_price',
                    render: function(data, type, row) {
                        return 'Rp.' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'transaction_status',
                    name: 'transaction_status',
                    render: function(data, type, row) {
                        var statusClass = '';

                        // Membuat kelas CSS berdasarkan nilai status
                        if (data === 'PENDING') {
                            statusClass = 'text-warning'; // Warna kuning untuk status pending
                        } else if (data === 'SHIPPING') {
                            statusClass = 'text-primary'; // Warna biru untuk status shipping
                        } else if (data === 'SUCCESS') {
                            statusClass = 'text-success'; // Warna hijau untuk status success
                        }

                        // Mengembalikan nilai dengan kelas CSS yang sesuai
                        return '<span class="' + statusClass + '">' + data + '</span>';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        var date = new Date(data);
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        return new Intl.DateTimeFormat('id-ID', options).format(date);
                    }
                },
            ]
        });
    </script>
@endpush
