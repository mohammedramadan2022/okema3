<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPC</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/libraries/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pdf/libraries/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pdf/libraries/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pdf/libraries/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pdf/custom/css/style.css') }}">
</head>

<body>
<div class="position-relative">

    <table class="w-100">
        <thead>
        <tr>
            <th colspan="10" class="border-0 p-0">
                <div class="watermark">
                    <img src="{{ asset('assets/pdf/images/MPC-logo13_black.png') }}" alt="Watermark">
                </div>
            </th>
        </tr>

        <tr>
            <th colspan="10" class="border-0 p-0">
                <div class="header">
                    <img src="{{ asset('assets/pdf/images/header.jpg') }}" alt="Header"
                         class="img-fluid mb-2">
                </div>
            </th>
        </tr>

        <tr>
            <th colspan="10" class="border-0 p-0">
                <div class="footer">

                    <img src="{{ asset('assets/pdf/images/footer.jpg') }}" alt="Watermark">
                </div>
                <div style="clear:both !important;">
            </th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="8" class="border-0">
                <h1 class="fw-bold text-center" style="color:#FF0101;">INVOICE</h1>
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="8" class="text-center fw-bolder bg-light-blue-color">
                INVOICE DETAILS
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Invoice No.</td>
            <td colspan="1" class="fw-bold fs-custom">
                {{ $invoiceData['setting'][''] }}{{ $invoiceData['invoice']->invoice_id }}</td>

            <td colspan="3" class="fw-bold fs-custom">Project/ Shop Name</td>
            <td colspan="2" class="fw-bold fs-custom">{{ $invoiceData['invoice']->shop_name }}</td>

            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Revision No.</td>
            <td colspan="1" class="fw-bold fs-custom"></td>
            <td colspan="3" class="fw-bold fs-custom">Location</td>
            <td colspan="2" class="fw-bold fs-custom">{{ $invoiceData['invoice']->location }}</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Invoice Date.</td>
            <td colspan="1" class="fw-bold fs-custom">{{ $invoiceData['invoice']->invoice_date }}</td>
            <td colspan="3" class="fw-bold fs-custom">Work Detail</td>
            <td colspan="2" class="fw-bold fs-custom">
                {{ $invoiceData['invoice']->type == 0 ? 'Maintenance' : 'Sales' }} </td>

            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="8" class="text-center fw-bolder bg-light-blue-color">Client Details</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Company Name</td>
            <td colspan="6" class="fw-bold fs-custom">{{ $invoiceData['client']->company_name }}
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Attention</td>
            <td colspan="6" class="fw-bold fs-custom">{{ $invoiceData['client']->attention }}</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Contact Number</td>
            <td colspan="6" class="fw-bold fs-custom">{{ $invoiceData['client']->contact }}</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="2" class="fw-bold fs-custom">Email Address</td>
            <td colspan="6" class="fw-bold fs-custom">{{ $invoiceData['client']->email }}</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td colspan="8" class="text-center fw-bolder bg-light-blue-color">Service Provided</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr>
            <td class="border-0 p-0"></td>
            <td class="text-center small fw-bold fs-custom bg-light-blue-color" style="width: 30px;">S/N</td>
            <td class="text-center small fw-bold fs-custom bg-light-blue-color" style="width: 30px;">REFERENCE</td>
            <td colspan="2" class="text-center fw-bold fs-custom bg-light-blue-color">DESCRIPTION</td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color" style="width: 40px;">QTY</td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color" style="width: 40px;">UNIT</td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color" style="width: 50px;">
                UNIT
                <br>
                <span>PRICE</span>
            </td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color" style="width: 50px;">
                TOTAL
                <br>
                <span>AMOUNT</span>
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        @foreach ($invoiceData['invoice']->items as $item)
            <tr class="detail-row">
                <td class="border-0 p-0"></td>
                <td class="text-center" style="width: 15px;">{{ $loop->iteration }}</td>

                <td class="text-center" style="width: 30px;">
                    @if($item->image)
                        <img style="height:100px; width: 75px; "
                             src="{{ asset('storage/uploads') . '/' . $item->image }}">
                    @endif
                </td>
                <td colspan="2" class="text-center fs-custom">
                    <ul class="dotted-list">
                        <li>{{ $item->product_name ?? $item->product->name ?? '' }}</li>
                    </ul>
                </td>
                <td class="text-center" style="width: 40px;">{{  $item->quantity }}</td>
                <td class="text-center" style="width: 40px;">{{ $item->unit ?? '---' }}</td>
                <td class="text-center" style="width: 50px;">{{ $item->price }}</td>
                <td class="text-center" style="width: 50px;">{{ $item->price * $item->quantity }}</td>
                <td class="border-0 p-0"></td>
            </tr>
        @endforeach

        <tr class="totals">
            <td class="border-0 p-0"></td>
            <td colspan="6" class="text-end fw-bold fs-custom bg-light-blue-color">SUB TOTAL</td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color">QAR</td>
            <td class="text-center fw-bold fs-custom bg-light-blue-color">{{ $invoiceData['invoice']->amount }}
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="totals">
            <td class="border-0 p-0"></td>
            <td colspan="6" class="text-end fw-bold fs-custom">Discount (if any )</td>
            <td class="text-center fw-bold fs-custom">QAR</td>
            <td class="text-center fw-bold fs-custom">-</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="totals">
            <td class="border-0 p-0"></td>
            <td colspan="6" class="text-end fw-bold bg-light-blue-color h6">NET TOTAL</td>
            <td class="text-center fw-bold bg-light-blue-color h6">QAR</td>
            <td class="text-center fw-bold bg-light-blue-color h6">{{ $invoiceData['invoice']->final_amount }}
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="terms">
            <td class="border-0 p-0"></td>
            <td colspan="8" class="text-center fw-bolder bg-light-blue-color">Terms and Conditions</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="terms">
            <td class="border-0 p-0"></td>
            <td colspan="8">
                @if ($invoiceData['invoice']->term)
                    <div class="d-flex justify-content-end">
                        {!!  $invoiceData['invoice']->term!!}
                    </div>
                @else
                    <ol>
                        <li><span class="fw-bold">Validity of Invoice:</span> This invoice is valid for
                            fifteen
                            (15) days from
                            the date of issue.
                        </li>
                        <li><span class="fw-bold">Payment Terms:</span> As Agreed terms and Conditions</li>
                        <li><span class="fw-bold">Delivery Time:</span> Estimated delivery time is 2- 3 weeks
                            from
                            the date of
                            confirmation and received of LPO.
                        </li>
                        <li><span class="fw-bold">Warranty:</span> NA</li>
                        <li><span class="fw-bold">Additional Costs:</span> Any additional costs such as customs
                            duties or taxes will
                            be borne by the client unless specified otherwise.
                        </li>
                        <li><span class="fw-bold">Shipping Charges:</span> NA</li>
                        <li><span class="fw-bold">Cancellation Policy:</span> Cancellations must be made one
                            week
                            before
                        </li>
                        <li><span class="fw-bold">Force Majeure:</span> We will not be responsible for delays
                            or
                            failures due to
                            circumstances beyond our control.
                        </li>
                    </ol>
                @endif

            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="signature">
            <td class="border-0 p-0"></td>
            <td colspan="2" class="text-left fw-bold fs-custom bg-light-blue-color">Prepared by:</td>
            <td colspan="6" class="text-left fw-bold fs-custom bg-light-blue-color">
                {{--                {{ auth()->guard('admin')->user()->name }}--}}

{{--                Modern Professional Contracting--}}
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="signature">
            <td class="border-0 p-0"></td>
            <td colspan="2" class="text-left fw-bold fs-custom bg-light-blue-color">
                <br>
                Authorized Person
                <br>
                <br>
            </td>
            <td colspan="6" class="text-left fw-bold fs-custom">MPC MANAGEMENT</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="signature">
            <td class="border-0 p-0"></td>
            <td colspan="2" class="text-left fw-bolder bg-light-blue-color">Signature/ Stamp</td>
            <td colspan="3" class="border-0 p-0" style="border-right:0 "></td>
            <td colspan="3" style="border-left:0 ">
                <div class="position-relative d-flex w-100" style="height: 100px; justify-content:start;">
                    <img src="{{ asset('assets/pdf/images/signature.png') }}" height="100" alt="Signature/ Stamp"
                         class="signature-img">
                </div>
            </td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="signature">
            <td class="border-0 p-0"></td>
            <td colspan="8" class="text-center fw-bolder bg-light-blue-color">Disclaimer</td>
            <td class="border-0 p-0"></td>
        </tr>

        <tr class="">
            <td class="border-0 p-0"></td>
            <td colspan="8" class="" >
                @if ($invoiceData['invoice']->note)
                    <div class="d-flex justify-content-end">
                        {!! $invoiceData['invoice']->note !!}
                    </div>

                @else
                    All invoices are based on the current cost of goods and services, and any changes in these
                    costs may affect
                    the final price.
                    This invoice does not constitute a contract, and the final order confirmation will be
                    provided
                    upon receipt of
                    the agreed
                    payment.
                @endif
            </td>
            <td class="border-0 p-0"></td>
        </tr>
        </tbody>
    </table>
</div>

<script src="{{ asset('assets/pdf/libraries/bootstrap/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('assets/pdf/libraries/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/pdf/libraries/fontawesome/js/all.js') }}"></script>
<script src="{{ asset('assets/pdf/libraries/fontawesome/js/all.min.js') }}"></script>
<script src="{{ asset('assets/pdf/libraries/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/pdf/custom/js/script.js') }}"></script>
</body>

</html>
