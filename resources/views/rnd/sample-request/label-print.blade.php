<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print label</title>
    <style>
        body {
            margin: 10px;
            padding: 10px;
        }

        .container-side {
            display: flex;
            margin-top: 10px;

        }

        .container {
            width: 9.69cm;
            height: 5.52cm;
            border: 2px solid #0072CE;
            padding: 10px;
            font-family: Arial, sans-serif;
            position: relative;
            box-sizing: border-box;
        }

        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -17px;
        }

        .label-header img {
            height: 50px;
            margin-left: -10px;

        }

        .label-content-header {
            margin-top: -19px;
            margin-left: -5px;
            display: flex;
            justify-content: first baseline;
        }

        .label-left-side .label-name-content {
            font-size: 10pt;
        }

        .label-right-side {
            margin-right: 10px;
            margin-left: 30px;
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
        }

        .label-right-side img {
            height: 30px;
        }

        .label-content-primary {
            margin-top: -10px;
            margin-left: -5px;
            display: flex;
            justify-content: space-between;
        }

        .table-content-product {
            width: 55%;
        }

        .table-data {
            font-size: 9px;
            line-height: 10px;
            font-weight: 800;
        }

        .sds-info {
            width: 42%;
        }

        .sds-info p {
            font-size: 7px;
            text-align: justify;
            line-height: 10px;
        }

        .footer {
            background: #0072CE;
            color: #fff;
            /* margin-left: -2%; */
            margin-top: -8px;
            width: 364.5px;
            height: 35px;
            position: absolute;
            bottom: 0;
            /* Letakkan footer di bagian bawah container */
            left: 0;
        }

        .footer .company-name {
            text-align: center;
            font-size: 8px;
        }

        .footer .address {
            text-align: center;
            font-size: 7px;
        }
    </style>
</head>

<body>
    <div class="container-side">
        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

        <div style="margin-left: 20px; margin-top: 20px"></div>

        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

    </div>
    <div class="container-side">
        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

        <div style="margin-left: 20px; margin-top: 20px"></div>

        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

    </div>
    <div class="container-side">
        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

        <div style="margin-left: 20px; margin-top: 20px"></div>

        <div class="container">
            <div class="label-header">
                <div class="label-logo">
                    <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                </div>
                <div class="label-info">
                    <h4 class="text-label-info">RETAIN!!!</h4>
                </div>
            </div>
            <div class="label-content-header">
                <div class="label-left-side">
                    <h3 class="label-name-content">Research & Development</h3>
                </div>
                <div class="label-right-side">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                    <img src="{{ asset('assets/ghs/202408063153-ZaP4V8uEMT.png') }}" alt="">
                </div>
            </div>
            <div class="label-content-primary">
                <div class="table-content-product">
                    <table class="table-data">
                        <tr>
                            <td>Product Name</td>
                            <td>: POWERSULFA 2100</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> (Triazine min. 75%)</td>
                        </tr>
                        <tr>
                            <td>Batch Number</td>
                            <td>: 01.128.04092024</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>: Mbak Hanna</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: 4th Sept. 2024</td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td>: 4th Sept. 2025</td>
                        </tr>
                        <tr>
                            <td>Nett</td>
                            <td>: 1000 mL</td>
                        </tr>
                    </table>
                </div>
                <div class="sds-info">
                    <p>Read safety data sheet carefully. Do not handle until
                        until all safety precautions have been read and
                        understood. Wash hands, forearms, and exposed area
                        thoroughly after handling. Do not eat, drink, or smoke
                        when using this product. Avoid release to the
                        environment. Water eye protection, protective clothing,
                        protective gloves.</p>
                </div>
            </div>
            <div class="footer">
                <p class="company-name">PT Zeus Kimiatama Indonesia</p>
                <p class="address">Jl Jababeka IV Blok V Kav. 74-75 Kel. Pasir Gombong Cikarang Utara Phone:
                    +62218934922
                </p>
            </div>
        </div>

    </div>


</body>

</html>
