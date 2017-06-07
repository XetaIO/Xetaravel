import Sidebar from './Sidebar';
import Console from './Console/Console';

class Xetaravel
{
    constructor()
    {
        let sidebar: Sidebar = new Sidebar();

        this.renderConsoleMessages();
    }

    /**
     * Render the messages in the console.
     *
     * @return {void}
     */
    protected renderConsoleMessages()
    {
        var information = new Console({
            title: 'color:#a3f5a3;background:#2f4052;font-weight:bold;',
            message: "\n %c  %c HELLO ! %c  %c  Don't forget that this website is open-source ! https://github.com/XetaIO/Xetaravel  %c  \n\n",
            width: 'padding:5px 0;',
            color: 'color:#fff;',
            primaryBackground: 'background:#5ccc5c;',
            cornerBackground: 'background:#a3f5a3;',
        });
        information.render();

        var warning = new Console({
            title: 'color:#e44;background:#2f4052;font-weight:bold;',
            message: "\n %c  %c ATTENTION %c  %c  DONT RUN ANY SCRIPT HERE ! IT WILL HAVE FULL ACCESS TO YOUR BROWSER AND YOUR ACCOUNT ! https://en.wikipedia.org/wiki/Self-XSS  %c  \n\n",
            width: 'padding:5px 0;',
            color: 'color:#fff;',
            primaryBackground: 'background:#c22;',
            cornerBackground: 'background:#e44;',
        });
        warning.render();
    }
}
const xetaravel = new Xetaravel();