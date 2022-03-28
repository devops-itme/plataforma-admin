@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom ">
        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h6 class="card-label">Log de usuarios</h6>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">EVENTO</th>
                        <th scope="col">CAUSANTE</th>
                        <th scope="col">ROL</th>
                        <th scope="col">ACCIÓN</th>
                        <th scope="col">FECHA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $item)
                        <tr>
                            <td>{{$item->log_name??''}}</td>
                            <td>{{$item->getCauser->name??''." ".$item->getCauser->last_name??''}}</td>
                            <td>{{$item->getCauser->getRole->name??''}}</td>
                            <td>{{$item->description??''}}</td>
                            <td>{{format_date(date($item->created_at))." ".date('h:i A', strtotime($item->created_at))??''}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
