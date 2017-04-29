declare function $(jQuery): any;

class Xeta
{
    /**
     * The CSRF token used in the application.
     *
     * @type {string}
     */
    private csrfToken: string;

    /**
     * The default configuration for the ScrollUp function.
     *
     * @type {object}
     */
    private scrollUpConfig = {
        scrollName : "scrollUp",
        scrollDistance : 300,
        scrollFrom : "top",
        scrollSpeed : 1000,
        easingType : "easeInOutCubic",
        animation : "fade",
        animationInSpeed : 200,
        animationOutSpeed : 200,
        scrollText : '<i class="fa fa-chevron-up"></i>',
        scrollTitle : " ",
        scrollImg : 0,
        activeOverlay : 0,
        zIndex : 1001
    };

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
    public constructor(csrfToken: string, scrollConfig: any)
    {
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
    protected initialize(): void
    {
        this.handleScroll();
    }

    /**
     * Get the current CSRF token.
     *
     * @method getCsrfToken
     *
     * @return {string} The current token.
     */
    public getCsrfToken(): string
    {
        return this.csrfToken;
    }

    /**
     * Initialize the scroll up event.
     *
     * @method handleScroll
     *
     * @return {void}
     */
    protected handleScroll(): void
    {
        $(document).scrollUp(this.scrollUpConfig);
    }
}
