<?

use Framework\Modules\Application;

Application::attachJsScript(__DIR__ . '/User.js');
Application::attachJsScript(__DIR__ . '/Image.js');
Application::attachJsScript(__DIR__ . '/Canvas.js');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<canvas id="canvas" style="border: 3px solid blue;"></canvas>
<form>
    <input type="file" id="loadImage" name="image">
</form>