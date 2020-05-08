function Canvas (elementId, contextId, width, height) {
    this.element = document.getElementById(elementId);
    this.context = this.element.getContext(contextId);
    this.width = width;
    this.height = height;
    this.picture = '';
}
Canvas.prototype.clear = function() {
    this.width = 750;
};
Canvas.prototype.update = function() {
    window.requestAnimationFrame(this.update.bind(this));
    this.clear();
    //this.render();
};
Canvas.prototype.render = function() {
    this.context.drawImage(
        this.picture,
        0, 0,
        this.picture.width, this.picture.height,
        0, 0,
        this.picture.width, this.picture.height
    );
};