var Xeta = (function () {
    /**
     * Constructor method.
     *
     * @method constructor
     *
     * @param {string} csrfToken The CSRF token used in the application.
     * @param {any} scrollConfig The scroll up configuration.
     *
     * @return {void}
     */
    function Xeta(csrfToken, scrollConfig) {
        /**
         * The default configuration for the ScrollUp function.
         *
         * @type {object}
         */
        this.scrollUpConfig = {
            scrollName: "scrollUp",
            scrollDistance: 300,
            scrollFrom: "top",
            scrollSpeed: 1000,
            easingType: "easeInOutCubic",
            animation: "fade",
            animationInSpeed: 200,
            animationOutSpeed: 200,
            scrollText: '<i class="fa fa-chevron-up"></i>',
            scrollTitle: " ",
            scrollImg: 0,
            activeOverlay: 0,
            zIndex: 1001
        };
        this.csrfToken = csrfToken;
        for (var index in scrollConfig) {
            this.scrollUpConfig[index] = scrollConfig[index];
        }
        this.initialize();
    }
    /**
     * Launch the application initialization.
     *
     * @method initialize
     *
     * @return {void}
     */
    Xeta.prototype.initialize = function () {
        this.handleScroll();
    };
    /**
     * Get the current CSRF token.
     *
     * @method getCsrfToken
     *
     * @return {string} The current token.
     */
    Xeta.prototype.getCsrfToken = function () {
        return this.csrfToken;
    };
    /**
     * Initialize the scroll up event.
     *
     * @method handleScroll
     *
     * @return {void}
     */
    Xeta.prototype.handleScroll = function () {
        $(document).scrollUp(this.scrollUpConfig);
    };
    return Xeta;
}());
