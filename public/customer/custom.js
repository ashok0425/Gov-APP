
(function ($) {
  "use strict"; // Start of use strict


  $(document).on('click', '.minus', function () {
    var sp = $(this).data('sp');
    var mp = $(this).data('mp');
    var $input = $(this).parent().find('.box');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    $('#sp').html(sp * count)
    $('#mp').html(mp * count)
    return false;
  });
  $(document).on('click', '.plus', function () {
    var sp = $(this).data('sp');
    var mp = $(this).data('mp');
    var $input = $(this).parent().find('.box');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    var count = parseInt($input.val());
    $('#sp').html(sp * count)
    $('#mp').html(mp * count)
    return false;
  });

  // Sidebar
  var $main_nav = $('#main-nav');
  var $toggle = $('.toggle');
  var defaultOptions = {
    disableAt: false,
    customToggle: $toggle,
    levelSpacing: 40,
    navTitle: 'App',
    levelTitles: true,
    levelTitleAsBack: true,
    pushContent: '#container',
    insertClose: 2
  };
  var Nav = $main_nav.hcOffcanvasNav(defaultOptions);

  // Coupons
  $('.coupons').slick({
    infinite: false,
    arrows: false,
    autoplay: true,
    slidesToShow: 1.3,
    slidesToScroll: 1,
  });

  // Top Picks - Homepage
  $('.top-picks').slick({
    infinite: false,
    arrows: false,
    autoplay: true,
    slidesToShow: 2.3,
    slidesToScroll: 1,
  });

  // All Categories - Homepage
  $('.all-cate').slick({
    infinite: false,
    arrows: false,
    autoplay: true,
    slidesToShow: 4.5,
    slidesToScroll: 4,
  });

  // Product Detail
  $('.product-slider').slick({
    arrows: false,
    autoplay: true,
    infinite: false,
    dots: true,
  });


  //product detail
  $(document).on('click', '#productcanvasBtn', function () {
    var product_id = $(this).data('product-id');
    $.ajax({
      url: `/product-detail/${product_id}`,
      type: 'GET', // or 'POST' depending on your server implementation
      data: { product_id: product_id }, // data to send to the server if needed
      success: function (response) {
        $('#productDetail').html(response)

      },
      error: function (xhr, status, error) {
        // Handle errors from the server or AJAX request
        console.error(error);
      }
    });
  });



  //orderdetail detail
  $(document).on('click', '.showorderDetail', function () {
    var order_id = $(this).data('orderid');
    $.ajax({
      url: `/order-detail/${order_id}`,
      type: 'GET', // or 'POST' depending on your server implementation
      success: function (response) {
        $('#orderdetailCanvas').html(response)

      },
      error: function (xhr, status, error) {
        // Handle errors from the server or AJAX request
        console.error(error);
      }
    });
  });


  $(document).on('submit', '#addTocart', function (e) {
    e.preventDefault();
    var formData = $(this).serializeArray();

    $.ajax({
      url: "/cart",
      type: 'POST', // or 'POST' depending on your server implementation
      data: formData, // data to send to the server if needed
      success: function (response) {
        if (response.success) {
          toastr.success(response.message);
          $('.cartCount').removeClass('d-none')
          $('.cartCount span').text(response.count);
        }else{
          toastr.error(response.message);
        }

      },
      error: function (xhr, status, error) {
        // Handle errors from the server or AJAX request
        toastr.error('Failed to add.Try again')

      }
    });
  });



  $(document).on('click', '.weight-radio', function (e) {
    var price = $(this).data('price');

    var qty = $('.box').val();
   var total = price * qty;
    $('#sp').html(total)
    $('#mp').html(total)
    $('.minus').data('mp', price)
    $('.minus').data('sp', price)
    $('.plus').data('mp', price)
    $('.plus').data('sp', price)
  });


  //product detail
  $(document).on('keyup', '#searchproduct', function () {
    var keyword = $(this).val();
    $.ajax({
      url: "/search",
      type: 'GET', // or 'POST' depending on your server implementation
      data: { keyword: keyword }, // data to send to the server if needed
      success: function (response) {
        $('.productCount').html(response.length)
        let html = '';

        // Loop through the products in the response
        response.forEach(product => {
            html += `<div class="col-6 mb-3"><div class="card bg-transparent border-0 overflow-hidden h-100 ps-3">
    <a
        href="#"
        class="link-dark"
        data-bs-toggle="offcanvas"
        data-bs-target="#productcanvas"
        aria-controls="productcanvasLabel"
        id="productcanvasBtn"
        data-product-id="${product.id}"
    >
        <div class="bg-white rounded-4 p-2 border position-relative product-box">
            <img
                src="${product.thumbnail}"
                alt="${product.name}"
                class="img-fluid h-100 d-block mx-auto"
                style="object-fit: contain"
                width="200px"
                height="200px"
            />
        </div>
    </a>`;

    if(product.discount!=0&&product.discount!=''){
    html+=`<div class="bg-info position-absolute top-0 text-white osahan-badge text-center mx-3">
        <b>${product.discount}</b>
        <br />
        OFF
        </div>`;
    }


    html+=`<div class="card-body p-0">
        <small class="text-muted">${product.category }</small>
        <p class="card-title fw-bold ">${product.name}</p>
    </div>
    <div
        class="card-footer bg-transparent border-0 d-flex align-items-center justify-content-between p-0"
    >
        <div>
        <p class='my-0 mb-1'> ${product.unit }</p>
            <p class="fw-bold m-0 "><sub>Rs</sub>${product.price }</p>
        </div>
        <button
            data-product-id="${product.id }"
            class="btn btn-outline-success fw-bold rounded-3 shadow-sm btn-sm"
            data-bs-toggle="offcanvas"
            data-bs-target="#productcanvas"
            aria-controls="productcanvasLabel"
            id="productcanvasBtn"
        >
            ADD
        </button>
    </div>
</div>
</div>
`;
        });

        // Inject the HTML into the product search result container
        $('#productsearchresult').html(html);
      },
      error: function (xhr, status, error) {
        // Handle errors from the server or AJAX request
        console.error(error);
      }
    });
  });


  // load imageafter 2 sec
  $(document).ready(function(){
    setTimeout(() => {
        $(function(){
    $.each(document.images, function(){
               var this_image = this;

               var src = $(this_image).attr('src') || '' ;
               if(!src.length > 0){
                   //this_image.src = options.loading; // show loading
                   var lsrc = $(this_image).attr('lsrc') || '' ;
                   if(lsrc.length > 0){
                    this_image.src = lsrc;
                   }
               }
           });
  });
    }, 600);
   })


   //requistion form

   $('#requisitionForm').on('submit',function(e){
       e.preventDefault();
       let form=$(this);
        var formData=form.serializeArray();

    $.ajax({
      url: "/requisition/store",
      type: 'POST', // or 'POST' depending on your server implementation
      data: formData, // data to send to the server if needed
      success: function (response) {
        if (response.success) {
          toastr.success(response.message);
          form[0].reset();
        }else{
          toastr.error(response.message);
        }

      },
      error: function (xhr, status, error) {
        // Handle errors from the server or AJAX request
        toastr.error('Failed to add.Try again')

      }
    });
   })

})(jQuery);

