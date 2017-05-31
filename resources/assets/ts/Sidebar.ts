export default class Sidebar
{

    /**
     * The sidebar element.
     *
     * @property {HTMLElement} sidebar
     */
    private sidebar: HTMLElement;

    /**
     * The sidebar trigger element.
     *
     * @property {HTMLElement} trigger
     */
    private trigger: HTMLElement;

    /**
     * The overlay element.
     *
     * @property {HTMLElement} overlay
     */
    private overlay: HTMLElement;

    /**
     * The constructor.
     */
    constructor()
    {
        this.sidebar = document.getElementById("sidebar");
        this.trigger = document.getElementById('sidebar-trigger');
        this.overlay = document.createElement('div');

        this.trigger.addEventListener('click', this.triggerListener, false);
    }

    /**
     * Closed the sidebar and remove the overlay.
     *
     * @method closeSidebar
     *
     * @return {void}
     */
    protected closeSidebar(): void
    {
        this.sidebar.classList.remove('sidebar-opened');
        this.sidebar.classList.add('sidebar-closed');
        this.overlay.parentNode.removeChild(this.overlay);

    }

    /**
     * The trigger listener.
     *
     * @method triggerListener
     *
     * @param {Event} event The event that was fired.
     *
     * @return {void}
     */
    private triggerListener = (event: Event): void =>
    {
        event.preventDefault();

        if (this.sidebar.classList.contains('sidebar-opened')) {
            this.closeSidebar();
        } else {
            this.sidebar.classList.remove('sidebar-closed');
            this.sidebar.classList.add('sidebar-opened');

            this.overlay.classList.add('sidebar-overlay');
            this.sidebar.parentNode.appendChild(this.overlay);

            this.overlay.addEventListener('click', this.overlayListener);
        }
    }

    /**
     * The overlay listener.
     *
     * @method overlayListener
     *
     * @param {Event} event The event that was fired.
     *
     * @return {void}
     */
    private overlayListener = (event: Event): void =>
    {
        this.closeSidebar();
        this.overlay.removeEventListener('click', this.overlayListener);
    }
}