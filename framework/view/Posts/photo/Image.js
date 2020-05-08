function Picture() {
}

Picture.prototype.upload = function(inputFile) {
    const reader = new FileReader();

    reader.readAsDataURL(inputFile);
    reader.onload = function() {
        this.image = new Image();
        this.image.src = reader.result;
    };
    console.log(this.image);
};