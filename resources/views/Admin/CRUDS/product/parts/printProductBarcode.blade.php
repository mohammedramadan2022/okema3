@extends('Admin.layouts.inc.app')
@section('title')
    {{__('admin.Print Product Barcode')}}
@endsection
@section('css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .barcode-print, .barcode-print * {
                visibility: visible;
            }
            .barcode-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="barcode-print">
        <img  style="margin-left: 10px;"  src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->code, 'C39', 1, 40) }}" alt="barcode" />
        <div style="font-size: 12px; margin-top: 5px;margin-left: 10px;"> {{ $product->code }}  ({{ $product->name }})</div>

    </div>
@endsection
