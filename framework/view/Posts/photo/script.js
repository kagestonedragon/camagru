function processImage() {
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    canvas.width = 750;
    canvas.height = 750;

    let image = '';
    const imageParams = {
        offsetX: 0,
        offsetY: 0,
        scale: 1
    };
    
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

    function update() {
        requestAnimationFrame(update);
        clearCanvas();

        context.drawImage(
            image,
            0, 0,
            image.width, image.height,
            imageParams.offsetX, imageParams.offsetY,
            image.width * imageParams.scale, image.height * imageParams.scale
        )
    }

    function clearCanvas() {
        canvas.width = canvas.width;
    }

    const loadImageInput = document.getElementById('loadImage');
    loadImageInput.addEventListener('change', function(e) {
        const file = loadImageInput.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            const newImage = new Image();
            newImage.onload = function () {
                image = newImage;
                update();
            }
            newImage.src = reader.result;
        }
    });
}

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        processImage();
    }
};
