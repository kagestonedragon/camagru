<?

use Framework\Modules\Application;

Application::attachJsScript(__DIR__ . '/script.js');
Application::attachJsScript(__DIR__ . '/canvas.js');
?>
<canvas id="canvas" style="border: 3px solid blue;"></canvas>

<script>
    function getMouse(element) {
        const mouse = {
            x: 0,
            y: 0,
            dx: 0,
            dy: 0,
            left: false,
            wheel: 0
        };

        mouse.update = function() {
            mouse.dx = 0;
            mouse.dy = 0;
            mouse.wheel = 0;
        };

        element.addEventListener('mousemove', function(e) {
            const rect = element.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            mouse.dx = x - mouse.x;
            mouse.dy = y - mouse.y;
            mouse.x = x;
            mouse.y = y;
        });
        element.addEventListener('mousedown', function(e) {
            if (e.button === 0) {
                mouse.left = true;
            }
        });
        element.addEventListener('mouseup', function(e) {
            if (e.button === 0) {
                mouse.left = false;
            }
        });
        element.addEventListener('mousewheel', function(e) {
            e.preventDefault();
            mouse.wheel = e.deltaY;
        });
    }

    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    canvas.width = 750;
    canvas.height = 750;

    update();
    function update() {
        requestAnimationFrame(update);
        clearCanvas();
    }

    function clearCanvas() {
        canvas.width = canvas.width;
    }


</script>
