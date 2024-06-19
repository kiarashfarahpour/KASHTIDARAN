/**
 * Sets the X-CSRF_TOKEN to use in ajax requests.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Show the contact info of commercial owner.
 *
 * @param commercial
 */
function getCommercialContact(commercial) {
    $.ajax({
        type: 'POST',
        url: "/commercials/" + commercial + "/contact",
        data: {
            _method: "POST",
        },
        success: function(message) {
            // Set sth
            if(message.status == 'success') {
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
              //  $('.commercialDetails').append(message.content);
              //  $('.commercialContact').html(message.contact);
              $('#agreementModal .modal-body').html(message.contact);
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function(e) {
            // Set sth
            iziToast.error({
                message: 'متاسفانه مشکلی در دریافت اطلاعات تماس آگهی‌دهنده پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
    $('#processing-modal').modal('hide');
}

/**
 * Toggle Bookmark status.
 *
 * @param commercial
 */
function toggleBookmark(commercial) {
    $.ajax({
        type: 'POST',
        url: "/bookmarks",
        data: {
            _method: "POST",
            commercial: commercial,
        },
        success: function (message) {
            // Set sth
            if (message.status == 'success') {
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
                $('.commercialDetails').append(message.contact);
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function (e) {
            // Set sth
            iziToast.error({
                message: 'متاسفانه مشکلی در نشان کردن آگهی پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
    hideProcessing();
}

function hideProcessing() {
    $('#processing-modal').on('shown.bs.modal', function (e) {
        $("#processing-modal").modal('hide');
    })
}


/**
 * Send the category id to getCategoryFields() function.
 */
$(document).ready(function () {
    $('#getCommercialContact').on('click', function() {
        var commercialSlug = $('#commercialSlug').val();
        $('#processing-modal').modal('hide');
        getCommercialContact(commercialSlug);
    });
    $('#bookmark').on('click', function() {
        var commercialSlug = $('#commercialSlug').val();
        getCommercialContact(commercialSlug);
    });
    $('#processing-modal').on('hidden.bs.modal', function (e) {
        $(this).modal('hide');
    });

    $('.toggleBookmark').click(function () {
        var commercial = $(this).closest('.bookmarkWrapper').find('.commercialSlug').val();
        $('#processing-modal').modal('show');
        toggleBookmark(commercial);
    });
});

/**
 * Find and replace fields of category inside the tab.
 *
 * @param category
 */
function getCategoryField(category, buy, slug) {
    $.ajax({
        type: 'POST',
        url: "/admin/commercials/fields",
        data: {
            _method: "POST",
            category: category,
            buy: buy,
            slug: slug
        },
        success: function(message) {
            // Set sth
            if(message.status == 'success') {
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
                $('#tab_information').html(message.fields);
                $('#buy').bootstrapToggle('destroy');
                var buy_label   = '';
                var sell_label  = '';
                if(message.category['buy'] == null) {
                    buy_label = 'خرید';
                } else {
                    buy_label = message.category['buy'];
                }
                if(message.category['sell'] == null) {
                    sell_label  = 'فروش';
                } else {
                    sell_label  = message.category['sell'];
                }
                $('#buy').attr('data-off', "<i class='fa fa-cart-plus text-red'></i>" + buy_label);
                $('#buy').attr('data-on', "<i class='fa fa-cart-arrow-down'></i>" + sell_label);
                $('#buy').bootstrapToggle();
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function(e) {
            // Set sth
            iziToast.error({
                message: 'متاسفانه مشکلی در دریافت فیلدهای دسته‌بندی پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
}

/**
 * Send the category id to getCategoryFields() function.
 */
$(document).ready(function () {
    $('.getCategoryFields').on('change', function() {
        var category = $(this).val();
        if ($('#buy').is(":checked")){
                var buy = 1;
        } else {
            var buy = 0;
        }
        var slug = $('#slug').val();
        if (typeof slug === 'undefined') {
            slug = null;
        }
        getCategoryField(category, buy, slug);
    });
    $('#buy').on('change', function() {
        var category = $('#category').val();
        if ($('#buy').is(":checked")){
                var buy = 1;
        } else {
            var buy = 0;
        }
        var slug = $('#slug').val();
        if (typeof slug === 'undefined') {
            slug = null;
        }
        getCategoryField(category, buy, slug);
    });
});

/**
 * Submit comment for the commercial.
 *
 * @param commercial
 */
function submitComment(commercial, name, mobile, content, is_private) {
    $.ajax({
        type: 'POST',
        url: "/z/" + commercial + "/comments",
        data: {
            _method: "POST",
            name: name,
            mobile: mobile,
            content: content,
            is_private: is_private
        },
        success: function(message) {
            // Set sth
            if(message.status == 'success') {
                $('#name').val('');
                $('#mobile').val('');
                $('#content').val('');
                $('#is_private').prop('checked', false);
                $('#processing-modal').modal('hide');
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function(e) {
            // Set sth
            iziToast.error({
                message: 'متاسفانه مشکلی در ارسال پیام پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
}

/**
 * Submit review for the commercial.
 *
 * @param article
 */
function submitReview(article, name, mobile, content) {
    $.ajax({
        type: 'POST',
        url: "/blog/" + article + "/reviews",
        data: {
            _method: "POST",
            name: name,
            mobile: mobile,
            content: content
        },
        success: function(message) {
            // Set sth
            if(message.status == 'success') {
                $('#name').val('');
                $('#mobile').val('');
                $('#content').val('');
                $('#processing-modal').modal('hide');
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function(e) {
            // Set sth
            iziToast.error({
                message: 'متاسفانه مشکلی در ارسال نظر پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
}


$(document).ready(function () {
    /**
     * Send the Commercial slug to submitComment() function.
     */
    $('#submitComment').on('click', function() {
        $('#processing-modal').modal('show');
        var commercial = $('#commercial_slug').val();
        var name = $('#name').val();
        var mobile = $('#mobile').val();
        var content = $('#content').val();
        var is_private = $('#is_private').val();
        submitComment(commercial, name, mobile, content, is_private);
    });

    /**
     * Send the Article slug to submitReview() function.
     */
    $('#submitReview').on('click', function() {
        $('#processing-modal').modal('show');
        var article = $('#article_slug').val();
        var name = $('#name').val();
        var mobile = $('#mobile').val();
        var content = $('#content').val();
        submitReview(article, name, mobile, content);
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function AutoScrollOff() {
    clearTimeout(autoScroll);
    content.removeClass("auto-scrolling-on").mCustomScrollbar("stop");
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

$(document).ready(function() {
    $('.buyState').on('click', function () {
        $('#cats').removeClass('d-none');
        $('.buyLabel').removeClass('active');
        $(this).closest('label').addClass('active');
        var to = 'type='+$(this).val();
        $('#cats button').each(function()
        {
            this.search = "";
            var href = $(this).attr('data-href');
            href += (href.match(/\?/) ? '&' : '?') + to;
            $(this).attr('data-href', href);
        });
        $('#createCommercial').closest('.row').addClass('d-none');
    });
    $('.createCommercial').on('click', function () {
        var href = $(this).attr('data-href');
        $('#createCommercial').closest('.row').removeClass('d-none');
        $('#createCommercial').attr('href', href);
    });
})

$('#owl-sug').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    rtl:true,
    responsive: {
        0: {
            items: 1.5
        },
        600: {
            items: 3
        },
        1000: {
            items: 5,
            loop: false,
            autoplay: false,
            mouseDrag: false,
            autoplayTimeout: 5000
        }
    }
})
// ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });
    $(".next-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);
    });
});
function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
$('.nav-tabs').on('click', 'li', function () {
    $('.nav-tabs li.active').removeClass('active');
    // $('.nav-tabs li.active').attr("disabled", true);
    $(this).addClass('active');
});
$('.nav-tabs li').click(function() {
    $(this).prevAll().addClass("completed");
     $(this).nextAll().removeClass("completed") 
});
//// select2

$(document).ready(function () {
    $(".select2").select2({
        dir: "rtl",
    });
});
// file upload
function dragNdrop(event) {
    var fileName = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("preview");
    var previewImg = document.createElement("img");
    previewImg.setAttribute("src", fileName);
    preview.appendChild(previewImg);
    document.getElementById("remove").style.display = "none";
}
function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}
function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}
 ///// product gallery
 $(document).ready(function() {

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 8; //globaly define number of elements per page
    var syncedSecondary = true;
  
    sync1.owlCarousel({
      items : 1,
      slideSpeed : 2000,
      autoplayHoverPause:true,
      nav: true,
      autoplay: true,
      dots: false,
      loop: true,
      rtl:true,
      responsiveRefreshRate : 200,
          navText: ['<i class="catch fa fa-angle-right"></i>','<i class="catch fa fa-angle-left"></i>'],
  }).on('changed.owl.carousel', syncPosition);
  
    sync2
      .on('initialized.owl.carousel', function () {
        sync2.find(".owl-item").eq(0).addClass("current");
      })
      .owlCarousel({
      items : 5,
      dots: false,
      nav: false,
      loop: false,
      mouseDrag: false,
      smartSpeed: 200,
      slideSpeed : 500,
      slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
      rtl:true,
      responsiveRefreshRate : 100
    }).on('changed.owl.carousel', syncPosition2);
  
    function syncPosition(el) {
      //if you set loop to false, you have to restore this next line
      //var current = el.item.index;
      
      //if you disable loop you have to comment this block
      var count = el.item.count-1;
      var current = Math.round(el.item.index - (el.item.count/2) - .5);
      
      if(current < 0) {
        current = count;
      }
      if(current > count) {
        current = 0;
      }
      
      //end block
  
      sync2
        .find(".owl-item")
        .removeClass("current")
        .eq(current)
        .addClass("current");
      var onscreen = sync2.find('.owl-item.active').length - 1;
      var start = sync2.find('.owl-item.active').first().index();
      var end = sync2.find('.owl-item.active').last().index();
      
      if (current > end) {
        sync2.data('owl.carousel').to(current, 100, true);
      }
      if (current < start) {
        sync2.data('owl.carousel').to(current - onscreen, 100, true);
      }
    }
    
    function syncPosition2(el) {
      if(syncedSecondary) {
        var number = el.item.index;
        sync1.data('owl.carousel').to(number, 100, true);
      }
    }
    
    sync2.on("click", ".owl-item", function(e){
      e.preventDefault();
      var number = $(this).index();
      sync1.data('owl.carousel').to(number, 300, true);
    });
  });
   

//   price range
var keypressSlider = document.querySelector(".slider-keypress");
var input0 = document.querySelector(".input-with-keypress-0");
var input1 = document.querySelector(".input-with-keypress-1");
var inputs = [input0, input1];

noUiSlider.create(keypressSlider, {
  start: [20, 80],
  connect: true,
  step: 1,
  range: {
    min: [1],
    max: [250]
  }
});

/* begin Inputs  */

/* end Inputs  */
keypressSlider.noUiSlider.on("update", function(values, handle) {
  inputs[handle].value = values[handle];

  /* begin Listen to keypress on the input */
  function setSliderHandle(i, value) {
    var r = [null, null];
    r[i] = value;
    keypressSlider.noUiSlider.set(r);
  }

  // Listen to keydown events on the input field.
  inputs.forEach(function(input, handle) {
    input.addEventListener("change", function() {
      setSliderHandle(handle, this.value);
    });

    input.addEventListener("keydown", function(e) {
      var values = keypressSlider.noUiSlider.get();
      var value = Number(values[handle]);

      // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
      var steps = keypressSlider.noUiSlider.steps();

      // [down, up]
      var step = steps[handle];

      var position;

      // 13 is enter,
      // 38 is key up,
      // 40 is key down.
      switch (e.which) {
        case 13:
          setSliderHandle(handle, this.value);
          break;

        case 38:
          // Get step to go increase slider value (up)
          position = step[1];

          // false = no step is set
          if (position === false) {
            position = 1;
          }

          // null = edge of slider
          if (position !== null) {
            setSliderHandle(handle, value + position);
          }

          break;

        case 40:
          position = step[0];

          if (position === false) {
            position = 1;
          }

          if (position !== null) {
            setSliderHandle(handle, value - position);
          }

          break;
      }
    });
  });
  /* end Listen to keypress on the input */
});

/* -------------------------------------------------------------------------
   end Style-2
 * ------------------------------------------------------------------------- */