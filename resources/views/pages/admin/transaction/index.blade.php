@extends('layouts.admin')

@section('title')
    Transactions
@endsection

@section('content')
    <!-- Section Content -->
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
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
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
@endsection


@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTable').DataTable({
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
                        // Ubah data menjadi objek Date
                        var date = new Date(data);

                        // Format tanggal menggunakan Intl.DateTimeFormat
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        return new Intl.DateTimeFormat('id-ID', options).format(date);
                    }
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        });
    </script>
@endpush
