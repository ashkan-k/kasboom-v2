@extends('layouts.front-master')

@section('Page_Title')
    مهارتکده کسب بوم -  سوالات متداول

@endsection


@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')

@endsection

@section('SliderDiv')
@endsection


@section('Content')
    <!--Faq section-->
    <section class="sptb">
        <br>
        <div class="container">
            <div class="panel-group1" id="accordion2">
                @foreach($faqs as $faq)
                <div class="panel panel-default mb-4 border p-0">
                    <div class="panel-heading1">
                        <h4 class="panel-title1">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{$faq->id}}" aria-expanded="false">{{$faq->question}}</a>
                        </h4>
                    </div>
                    <div id="collapse_{{$faq->id}}" class="panel-collapse collapse active" role="tabpanel" aria-expanded="false">
                        <div class="panel-body bg-white">
                            <p>{!! $faq->answer !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <br>
    </section><!--/Faq section-->


@endsection


@section('Page_JS')

@endsection
