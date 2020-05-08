function processImage() {
    // Ожидание загрузки изображения
    const loadImageInput = document.getElementById('loadImage');
    loadImageInput.addEventListener('change', async function(e) {
        const currentUser = new User();
        const canvas = new Canvas('canvas', '2d', 750, 750);
        const mainPicture = new Picture();

        await mainPicture.upload(loadImageInput.files[0]);
        canvas.picture = mainPicture.image;
        console.log(mainPicture.image);
        canvas.update();
    });
}

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        processImage();
    }
};
