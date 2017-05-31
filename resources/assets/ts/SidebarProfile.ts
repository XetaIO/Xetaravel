export default class SidebarProfile
{
    /**
     * The sidebar element.
     *
     * @property {HTMLElement} sidebar
     */
    private sidebar: HTMLElement;

    /**
     * The width size of the window.
     *
     * @property {number} width
     */
    private width: number = window.innerWidth;

    /**
     * The minimum width required to trigger the sidebar.
     *
     * @property {number} minWidth
     */
    private minWidth: number;

    /**
     * The number of pixel between the sidebar and the top of the document.
     *
     * @property {number} sidebarTop
     */
    private sidebarTop: number;

    /**
     * Constructor.
     *
     * @param {HTMLElement} sidebar The sidebar element.
     * @param {number} minWidth The minimum width required to trigger the sidebar.
     */
    constructor(sidebar: HTMLElement, minWidth: number = 992)
    {
        this.sidebar = sidebar;
        this.minWidth = minWidth;

        if (this.sidebar !== null && this.width >= this.minWidth) {
            this.sidebarTop = this.sidebar.getBoundingClientRect().top + document.body.scrollTop - 1;

            document.addEventListener('scroll', this.scrollListener);
        }
    }

    /**
     * The scroll listener.
     *
     * @method scrollListener
     *
     * @param {Event} event The event that was fired.
     *
     * @return {void}
     */
    private scrollListener = (event: Event): void =>
    {
        let navbarHeight = document.getElementById('navbar').offsetHeight;
        let scrollStart = document.body.scrollTop;
        let top = this.sidebarTop - navbarHeight;

        if (scrollStart > top && !this.sidebar.classList.contains('fixed')) {
            this.sidebar.classList.add('fixed');
        }

        if (scrollStart < top && this.sidebar.classList.contains('fixed')) {
            this.sidebar.classList.remove('fixed');
        }
    }

}