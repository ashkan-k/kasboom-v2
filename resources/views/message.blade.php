@extends('master')

@section('Page_Title')
    کسب بوم - اطلاع رسانی
@endsection

@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')

@endsection

@section('SliderDiv')
@endsection


@section('Content')

    <div class="sptb" >
        <div class="header-text1 mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12 d-block mx-auto">
                        <div class="text-center text-white text-property">
                            <br>
                            <br>
                            <h3 class="" style="font-family: VazirBold">پیغام اطلاع رسانی</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /header-text -->
    </div>


    <!--section-->
    <section class="sptb margin-bottom">
        <br>
        <br>

        <div class="container">
            <div class="text-justify text-center">
                <h3 class="mb-4 font-weight-semibold" style="font-family: VazirBold">{{$title}}</h3>
                <h4 class="mb-4 font-weight-semibold" style="font-family: VazirBold">{{$message}}</h4>
                @if(isset($redirect))
                    <a class="btn btn-primary" href="{{$redirect}}" style="font-family: VazirMedium">
                @else
                    <a class="btn btn-primary" href="#" style="font-family: VazirMedium">
                @endif
                        &nbsp;برگشت&nbsp;<i class="fa fa-backward"></i>
                </a>

            </div>
        </div>
        <br>

    </section><!--/section-->
@endsection


@section('Page_JS')

@endsection
