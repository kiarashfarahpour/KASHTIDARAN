{{--<script src="{{ asset('vendor/popper/js/popper.min.js') }}"></script>--}}
<script src="{{ asset('vendor/jquery/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
{{--<script>window.jQuery || document.write('<script src="{{ asset('assets/js/vendor/jquery.slim.min.js') }}"><\/script>')</script>--}}
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js?v=0.0.20') }}" defer></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-176124702-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-176124702-1');
  
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TGVQWT4');

</script>
<script>
    $('.owl-sug').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        // nav:true,
        rtl:true,
        responsive: {
            0: {
                items: 2,
                dots: false,
            },
            600: {
                items: 3,
                dots: false,
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
</script>
