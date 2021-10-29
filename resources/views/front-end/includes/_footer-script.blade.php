<!-- JavaScript files-->
<script src="{{ asset('js/app.js') }}" defer></script>
{{--
<script src="{{ asset('front-end/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('front-end/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
--}}

<script src="{{ asset('front-end/vendor/lightbox2/js/lightbox.min.js') }}"></script>
<script src="{{ asset('front-end/vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('front-end/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('front-end/vendor/owl.carousel2/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front-end/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
<script src="{{ asset('front-end/js/front.js') }}"></script>

<script>
    // ------------------------------------------------------- //
    //   Inject SVG Sprite -
    //   see more here
    //   https://css-tricks.com/ajaxing-svg-sprite/
    // ------------------------------------------------------ //
    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }

    // this is set to BootstrapTemple website as you cannot
    // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
    // while using file:// protocol
    // pls don't forget to change to your domain :)
    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

</script>