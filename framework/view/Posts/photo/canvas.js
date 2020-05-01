function Canvas(DOMId, width, height) {
    this.canvas = document.getElementById(DOMId);
    this.context = this.canvas.getContext('2d');
    this.width = width;
    this.height = height;
}

Canvas.prototype.clear = function() {
    this.width = this.width;
}

Canvas.prototype.update = function() {
    requestAnimationFrame(this.update.bind(this));
    this.clear();
}