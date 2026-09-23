@extends('layouts.app')

@section('tieude')
Quản lý khoa
@endsection

@section('noidung')
<div class="table-responsive">
    <table class="table table-lg">
        <thead>
            <tr>
                <th>Mã khoa</th>
                <th>Tên khoa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($khoas as $k)
            <tr>
                <td>{{ $k->ma_khoa }}</td>
                <td>{{ $k->ten_khoa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection