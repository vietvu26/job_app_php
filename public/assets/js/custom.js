$(document).ready(function () {
    var lazyLoadInstance = new LazyLoad({
        elements_selector:
            "img.lazy, video.lazy, div.lazy, section.lazy, header.lazy, footer.lazy,iframe.lazy",
    });
    $(".notification-btn").on("click", function () {
        $(".notification-list").toggleClass("active");
    });
});
