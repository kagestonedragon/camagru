<?

use Framework\Modules\Application;

Application::attachJsScript(__DIR__ . '/script.js');
Application::attachJsScript(__DIR__ . '/canvas.js');
?>
<canvas id="canvas" style="border: 3px solid blue;"></canvas>

<script>
    function Picture() {
        this.offsetX = 0;
        this.offsetY = 0;
        this.scale = 1;
    }

    const canvas = new Canvas('canvas', 750, 750);
    canvas.update();
</script>
