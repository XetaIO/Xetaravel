import Sidebar from './Sidebar';
import SidebarProfile from './SidebarProfile';



class Xetaravel
{
    constructor()
    {
        //let discuss: Discuss = new Discuss();
        //let blog: Blog = new Blog();
        //let sidebar: Sidebar = new Sidebar();
        let sidebarProfile: SidebarProfile = new SidebarProfile(
            document.getElementById('sidebar-profile')
        );

        //this.renderConsoleMessages();
    }

}
const xetaravel = new Xetaravel();