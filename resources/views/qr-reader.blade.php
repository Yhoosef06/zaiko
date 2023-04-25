@extends('layouts.pages.yields')

@section('content')
    {{-- <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script> --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="container">
        <div>
            <h1>QR Scanner</h1>
            <div id="reader"></div>
        </div>
    </div>

    <div id="result"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@endsection
