var tooltip = document.querySelector('.map-tooltip');
var iranMap = document.getElementById("iran-map");
var ostanPath = iranMap.querySelectorAll('path.citymap-name');

ostanPath.forEach(item => {
    item.addEventListener('mouseenter', function () {
        tooltip.innerHTML = item.getAttribute('data-tooltip');
        tooltip.style.display = 'block';
    });
    item.addEventListener('mousemove', function (e) {
        var x = e.clientX,
            y = e.clientY;
        tooltip.style.top = (y - 40) + "px";
        tooltip.style.left = (x - 0) + "px";
    });
    item.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none';
    });
});
