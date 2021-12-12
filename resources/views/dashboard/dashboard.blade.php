@extends('layouts.main')
@section('content')
<!-- /**
hallo {{ Auth::user()->name }}
{{ var_dump($data['total_user']); }}
{{ $data['total_user'] }}
*/ -->
<div class="row g-4">
    <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
        <div class="d-flex card-dashboard">
            <div class="bg-success left-border"></div>
            <div class="d-flex p-3 align-items-center" style="width: 100%;">
                <div class="" style="width: 50%;">
                    <p class="title text-success">TOTAL BARANG</p>
                    <h3 class="align-middle text-success"><?= $data['total_barang'] ?></h3>
                </div>
                <div class="" style="text-align: center; width: 50%;">
                    <i class="fa fa-airplay text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
        <div class="d-flex card-dashboard">
            <div class="bg-primary left-border"></div>
            <div class="d-flex p-3 align-items-center" style="width: 100%;">
                <div class="" style="width: 50%;">
                    <p class="title text-primary">TOTAL SUPPLIER</p>
                    <h3 class="align-middle text-primary"><?= $data['total_supplier'] ?></h3>
                </div>
                <div class="" style="text-align: center; width: 50%;">
                    <i class="fa fa-users text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
        <div class="d-flex card-dashboard">
            <div class="bg-warning left-border"></div>
            <div class="d-flex p-3 align-items-center" style="width: 100%;">
                <div class="" style="width: 50%;">
                    <p class="title text-warning">TOTAL USER</p>
                    <h3 class="align-middle text-warning"><?= $data['total_user'] ?></h3>
                </div>
                <div class="" style="text-align: center; width: 50%;">
                    <i class="fa fa-users text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .card-dashboard {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
        background: #FFFFFF;
        border-radius: 8px;
    }

    .card-dashboard .left-border {
        width: 10px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .card-dashboard .title {
        font-size: 1.25rem;
        line-height: 1.75rem;
        font-weight: 600;
    }

    .card-dashboard i {
        font-size: 50px;
    }
</style>