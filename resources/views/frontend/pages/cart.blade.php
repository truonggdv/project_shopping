@extends('frontend.layouts.index')
@section('title','Giỏ hàng')
@section('content')
<!-- Breadcrumb Begin -->

    


<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                    <span>Giỏ hàng</span>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Breadcrumb End -->
    
    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
    <div class="container">
        @if(Cart::count() > 0)
        <form name="update-cart" id="update-cart">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table id="details-cart">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td class="cart__product__item">
                                    {{-- <input style="display: none" type="text" name="rowId[]" value="{{$item->rowId}}"> --}}
                                        <img width="120" height="130" src="{{\App\Library\Files::media( $item->options->image )}}" alt="">
                                        <div class="cart__product__item__title">
                                            <h6> {{$item->name}} </h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        <p style="font-weight:bold" >Size: {{$item->options->size}} <br /> Màu: {{$item->options->color}} </p>
                                        </div>
                                    </td>
                                    <td class="cart__price">{{ number_format($item->price) }} VNĐ</td>
                                    <td class="cart__quantity">
                                        <div class="pro-qty" data-id="{{$item->rowId}}">
                                            <input type="text" class="data-qty" readonly name="qty" value="{{$item->qty}}">
                                        </div>
                                    </td>
                                    <td class="cart__total">{{ number_format($item->price*$item->qty) }} VNĐ</td>
                                    <td class="cart__close">
                                            {{-- <button style="border: none;" type="submit"><span class="icon_close"></span></button> --}}
                                            <span class="icon_close" data-id="{{$item->rowId}}"></span>
                                    </td>
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="/">Tiếp tục mua sắm</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <button type="submit" style="border:none;background:red;color:#fff;border-radius:1px;padding: 14px 30px 12px;font-weight: 600;"><span class="icon_loading" style="display: none"></span> Cập nhật giỏ hàng</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-6">

            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Tổng giỏ hàng</h6>
                    <ul>
                        <li>Tổng tiền hàng <span>{{$total}} VNĐ</span></li>
                        <li>Tổng thanh toán <span>{{$total}} VNĐ</span></li>
                    </ul>
                    <a href="{{url('cart/cart-done')}}" class="primary-btn">Đặt hàng</a>
                </div>
            </div>
        </div>
        @else
        <h5 class="text-center mb-5">Giỏ hàng rỗng</h5>
        <div class="cart__btn text-center">
            <a href="/">Bắt đầu mua sắm</a>
        </div>
        @endif
    </div>
    </section>
    
    <div class="modal fade" id="modal-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" style="font-weight: 400;font-family: 'Roboto', sans-serif;font-size:16px">Xóa sản phẩm</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Bạn có muốn xóa sản phẩm này khỏi giỏ hàng ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
              <div id="button-action">

              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Shop Cart Section End -->
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".pro-qty").on("click",".qtybtn", function(event){
            event.preventDefault();
            var rowId = $(".pro-qty").data("id");
            var qty =  $(".data-qty").val();
            $.ajax({
                type: 'POST',
                url: '/cart/update',
                data: {qty:qty,rowId:rowId},
                cache: false,
                contentType: false,
                processData: false,
            })
            
        });
        $(".icon_close").click(function(event){
            event.preventDefault();
            var id = $(this).data("id");
            $("#button-action").html('<button type="button" class="btn btn-danger" id="button-delete" data-id='+id+' style="color: #fff">Xóa</button>');
            $("#modal-cart").modal('show');
        });
        $("#button-action").on('click',"#button-delete",function(event){
            event.preventDefault();
            var id = $(this).data("id");
            // alert(id);
            $.ajax({
                type: 'POST',
                url: '/cart/delete/'+id,
                cache: false,
                contentType: false,
                processData: false, 
                success: (data) =>{
                    if(data.errors){
                        swal(
                        'Lỗi !',
                        data.errors,
                        'error'
                    )
                    }else{
                        $("#modal-cart").modal('hide');
                        $("#details-cart").load(window.location + " #details-cart");
                        // $(".cart__total__procced").load(window.location + " .cart__total__procced");
                        // location.reload();
                        toastr.success(data.success, 'Thông báo', {timeOut: 3000});
                    }
                }
            });
        })
    </script>
@stop