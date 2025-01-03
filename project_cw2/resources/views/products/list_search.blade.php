@extends('main')

@section('content')
<div class="container">
    <form class="bg0 p-t-130 p-b-85" method="post">
        @include('admin.alert')
        <div class="row isotope-grid">
            @foreach($products as $key => $product)

            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="../thumb/{{$product->thumb}}" alt="{{ $product->name }}" height="200px">
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="/san-pham/{{ Crypt::encrypt($product->id) }}-{{ Str::slug($product->name, '-') }}.html"
                                class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{ $product->name }}
                            </a>

                            <span class="stext-105 cl3">
                                {!! \App\Helpers\Helper::price($product->price, $product->price_sale) !!}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if (count($products) != 0)

    </form>



</div>

@else
<div class="text-center">
    <h2>Không tìm thấy sản phẩm !!! </h2>
</div>
@endif
@endsection