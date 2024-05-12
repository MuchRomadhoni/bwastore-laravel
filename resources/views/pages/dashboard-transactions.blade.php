@extends('layouts.user')

@section('title')
    Store Dashboard Transaction
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>
            <div class="dashboard-content">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="buy-tab" data-toggle="tab" href="#buy" role="tab"
                            aria-controls="buy" aria-selected="false">Buy Product</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($buyTransactions as $buyTransaction)
                                    <a class="card card-list d-block"
                                        href="{{ route('dashboard-transaction-details', $buyTransaction->id) }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img src="{{ Storage::url($buyTransaction->product->galleries->first()->photos ?? '') }}"
                                                        class="w-100" />
                                                </div>
                                                <div class="col-md-4">
                                                    {{ $buyTransaction->product->name }}
                                                </div>
                                                <div class="col-md-3">
                                                    {{ $buyTransaction->product->user->store_name }}
                                                </div>
                                                <div class="col-md-3">
                                                    {{ $buyTransaction->created_at }}
                                                </div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/dashboard-arrow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
