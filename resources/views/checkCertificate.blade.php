@extends('layouts.front-master')

@section('Page_Title')
    کسب بوم - استعلام گواهینامه
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <!-- Certificate Search -->
    <div class="certificate-search-content" style="margin-top: 170px !important;">
        <div class="container-lg">
            <div class="certificate-inner">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-7 col-sm-12 order-2 order-md-1 order-lg-1">
                        <div class="title">
                            <h1><i class="mdi mdi-magnify"></i>استعلام گواهینامه</h1>
                            <p>شماره گواهینامه را از چپ به راست وارد کنید</p>
                        </div>
                        <div class="inputs-group">
                            <input id="idCerificate" type="text" class="input" maxlength="11">
                            <input id="userIdCerificate" type="text" class="input" maxlength="11">
                            <select id="typeCerificate" class="select">
                                <option value="الف">الف</option>
                                <option value="ب">ب</option>
                                <option value="م">م</option>
                                <option value="د">د</option>
                            </select>
                            <select id="yearCerificate" class="select">
                                <option value="400">400</option>
                                <option value="401">401</option>
                                <option value="402">402</option>
                            </select>
                        </div>
                        <div id="alertCerificate" class="alert"></div>
                        <div class="button-group">
                            <a id="submitCheckCerificate" href="javascript:void(0)"
                               class="btn btn-default icon-right"><i class="mdi mdi-magnify"></i>استعلام گواهینامه</a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 order-1 order-md-2 order-lg-2">
                        <div class="image">
                            <img src="/assets-v2/images/icons/certificate-search.svg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('Page_JS')
    <script>
        checkCertificate = function () {
            var form = new FormData();
            form.append("yearCerificate", $('#yearCerificate').find(":selected").text());
            form.append("typeCerificate", $('#typeCerificate').find(":selected").text());
            form.append("userIdCerificate", $('#userIdCerificate').val());
            form.append("idCerificate", $('#idCerificate').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "check-certificate",
                type: "POST",
                data: form,
                processData: false,
                contentType: false,
                async: true,
                success: function (data) {
                    $("#alertCerificate").removeClass('active')
                    window.open(data.url, '_self')
                },
                error: function (data) {
                    $("#alertCerificate").addClass('active');
                    $("#alertCerificate").text(data.responseJSON.message);
                }
            });
        };

        $("#submitCheckCerificate").click(function () {
            checkCertificate();
        });
    </script>
@endsection
