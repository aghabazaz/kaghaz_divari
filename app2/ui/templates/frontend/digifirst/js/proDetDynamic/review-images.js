if (Ave == undefined) {
    var Ave = {};
}

Ave.ReviewImages = function () {
    this.initialize.apply(this, arguments);
};

Ave.ReviewImages.prototype =
{
    titleBigImage: 'Click to open in separate window',
    initialize: function (config) {
        if (config.titleBigImage) {
            this.titleBigImage = config.titleBigImage;
        }
        var reviewImagesInstance = this;
        $$('.ave-review-images li').each(function (element) {
            element.observe('click', reviewImagesInstance.showBigImage);
        });
    },
    showBigImage: function (e) {
        function clearActive() {
            $$('.ave-review-images li').each(function (element) {
                element.removeClassName('active');
            });
            $$('div.ave-review-big-image').each(function (target) {
                target.setStyle({
                    display: 'none'
                });
            });
        }
        if (Ave.ReviewImages.prototype.hasClass(e.currentTarget, 'active')) {
            clearActive();
            return;
        }
        clearActive();
        e.currentTarget.addClassName('active');
        var bigContainer = $(e.currentTarget).up('ul').next('div.ave-review-big-image');
        var activeImagePath = e.currentTarget.getElementsByTagName("img")[0].getAttribute("src");
        bigContainer.innerHTML = '<a href="' + activeImagePath + '" target="_blank" title="' + ave_review_images.titleBigImage + '"><img src="' + activeImagePath + '"/></a>';
        bigContainer.setStyle({
            display: 'block'
        });
    },
    hasClass: function (element, cls) {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }
};