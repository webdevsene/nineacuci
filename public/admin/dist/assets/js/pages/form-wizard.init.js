$(function() {
    $("#basic-example")
        .steps({ headerTag: "h5", bodyTag: "section", transitionEffect: "slide" }),
        $("#vertical-example").steps({ headerTag: "h5", bodyTag: "section", transitionEffect: "slide", stepsOrientation: "vertical" })
});