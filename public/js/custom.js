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
            if(message.status == 'success') {
                iziToast.success({
                    message: message.body,
                    'position': 'topLeft'
                });
              $('#agreementModal .modal-body').html(message.contact);
            } else {
                iziToast.error({
                    message: message.body,
                    'position': 'topLeft'
                });
            }
        },
        error: function(e) {
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
            iziToast.error({
                message: 'متاسفانه مشکلی در نشان کردن آگهی پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
    hideProcessing();
}

function iAmReady(commercial) {
    $.ajax({
        type: 'POST',
        url: "/iam",
        data: {
            _method: "POST",
            commercial: commercial,
        },
        success: function (message) {
            if (message.status == 'success') {
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
        error: function (e) {
            iziToast.error({
                message: 'متاسفانه مشکلی در ثبت اعلام آمادگی پیش آمد.',
                'position': 'topLeft'
            });
        }
    });
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
    $('#i-am-ready').on('click', function() {
        var commercial = $(this).attr('data-com');
        iAmReady(commercial);
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

$('.plab-view-mode-grid').click(function () {
    "use strict";
    $(this).addClass('active');
    $('.plab-view-mode-list').removeClass('active');
    $('.box-ads-wrapper').addClass('three_per_row');
    $('.box-ads-wrapper').removeClass('prod_lst');
});

$('.plab-view-mode-list').click(function () {
    "use strict";
    $(this).addClass('active');
    $('.plab-view-mode-grid').removeClass('active');
    $('.box-ads-wrapper').addClass('prod_lst');
    $('.box-ads-wrapper').removeClass('three_per_row');
});

const ready = (selector, callback) => {
    window.addEventListener('DOMContentLoaded', function () {
        const elems = [...document.querySelectorAll(selector)];
        if (elems.length) {
            for (let elem of elems) {
                callback(elem);
            }
        }
    });
};

ready('.counter', (stat) => {
    // pattern used to seperate input number from html into an array of numbers and non numbers. EX $65.3M -> ["$65.3M", "$", "65", ".", "3", "M"]
    const patt = /(\D+)?(\d+)(\D+)?(\d+)?(\D+)?/;
    const time = 1000;
    let result = [...patt.exec(stat.textContent)];
    let fresh = true;
    let ticks;

    // Remove first full match from result array (we dont need the full match, just the individual match groups).
    result.shift();
    // Remove undefined values from result array where they didnt have a match in one of the optional regex groups
    result = result.filter(res => res != null);

    while (stat.firstChild) {
        stat.removeChild(stat.firstChild);
    }

    for (let res of result) {
        if (isNaN(res)) {
            stat.insertAdjacentHTML('beforeend', `<span>${res}</span>`);
        } else {
            for (let i = 0; i < res.length; i++) {
                stat.insertAdjacentHTML('beforeend',
                    `<span data-value="${res[i]}">
						<span>&ndash;</span>
						${Array(parseInt(res[i]) + 1).join(0).split(0).map((x, j) => `
							<span>${j}</span>
						`).join('')}
					</span>`
                );
            }
        }
    }

    ticks = [...stat.querySelectorAll('span[data-value]')];

    let activate = () => {
        let top = stat.getBoundingClientRect().top;
        let offset = (window.innerHeight * 3 / 4);

        setTimeout(() => {
            fresh = false;
        }, time);

        if (top < offset) {
            setTimeout(() => {
                for (let tick of ticks) {
                    let dist = parseInt(tick.getAttribute('data-value')) + 1;
                    tick.style.transform = `translateY(-${(dist) * 100}%)`
                }
            }, fresh ? time : 0);
            window.removeEventListener('scroll', activate);
        }
    }
    window.addEventListener('scroll', activate);
    activate();
});

function AutoScrollOff() {
    clearTimeout(autoScroll);
    content.removeClass("auto-scrolling-on").mCustomScrollbar("stop");
}


$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

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
// ========respansive-menu -->
$('.menu-bar- , .overlay').click(function () {
    $('.menu-bar-').toggleClass('clicked');
    $('#nav').toggleClass('show');
});

//============*=*=*=*=*= sliders
$('.owl-carousel.mob-product').owlCarousel({
    rtl:true,
    stagePadding: 15,
    margin:10,
    nav:true,
    responsive:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
$('.owl-carousel.mob-sl-menu').owlCarousel({
    rtl:true,
    stagePadding: 15,
    margin:10,
    nav:true,
    responsive:true,
    responsive:{
        0:{
            items:4
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})

//============*=*=*=*=*= back to top
$(document).ready(function(){
    $('body').append('<div id="scrollTop" class="btn btn-success"><div class="circle"><div class="wave"><i class="fas fa-angle-double-up"></i><span class="glyphicon glyphicon glyphicon-arrow-up"></span></div></div></div>');
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#scrollTop').fadeIn();
        } else {
            $('#scrollTop').fadeOut();
        }
    });

    $('#scrollTop').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '3000');
    });
});

//============ Multi-Slider-->
$(document).ready(function() {
	$('.owl-carousel.logo--slider').owlCarousel({
		rtl:true,
		loop: true,
		autoplay: true,
		margin: 0, items: 9,
		responsiveClass: true,
		responsive: {
			0: {
				items: 4, margin: 0,
				nav: true
			},
			600: {
				items: 6,  margin: 0,
				nav: false
			},
			1000: {
				items: 9,
				nav: true,
				loop: false,
				margin: 0
			}
		}
	})
})

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