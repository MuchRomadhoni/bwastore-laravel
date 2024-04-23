@extends('layouts.user')

@section('title')
    Store Dashboard Transaction Detail
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ $transaction->code }}</h2>
                <p class="dashboard-subtitle">
                    Transaction Details
                </p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                            alt="" class="w-100 mb-3" />
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">{{ $transaction->transaction->user->name }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Product Name</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->product->name }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">
                                                    Date of Transaction
                                                </div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->created_at }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">
                                                    {{ $transaction->transaction->transaction_status }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">Rp.
                                                    {{ number_format($transaction->transaction->total_price) }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->phone_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <h5>
                                            Shipping Informations
                                        </h5>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address 1</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->address_one }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address 2</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->address_two }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">
                                                    Province
                                                </div>
                                                <div class="product-subtitle">
                                                    {{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">City</div>
                                                <div class="product-subtitle">
                                                    {{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->zip_code ?? '' }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->country ?? '' }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="product-title">Shipping Status</div>
                                                        <div class="product-subtitle">
                                                            {{ $transaction->shipping_status }}
                                                        </div>
                                                    </div>
                                                    @if ($transaction->shipping_status == 'SHIPPING')
                                                        <div class="col-md-3">
                                                            <div class="product-title">Input Resi</div>
                                                            <div class="product-subtitle">
                                                                {{ $transaction->resi }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
