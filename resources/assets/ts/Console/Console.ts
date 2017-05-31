import { ConsoleInterface } from './ConsoleInterface'

export default class Console
{
    /**
     * The options being used to create the message.
     *
     * @property {ConsoleInterface} options
     */
    protected options: ConsoleInterface;

    /**
     * Constructor.
     *
     * @param {ConsoleInterface} options The options to pass to the class.
     */
    constructor(options: ConsoleInterface)
    {
        this.options = options;
    }

    /**
     * Render the message.
     *
     *@return {void}
     */
    public render()
    {
        let message = [
            this.options.message,
            this.options.primaryBackground + this.options.width,
            this.options.title + this.options.width,
            this.options.cornerBackground + this.options.width,
            this.options.color + this.options.primaryBackground + this.options.width,
            this.options.cornerBackground + this.options.width
        ];
        console.log.apply(console, message);
    }
}