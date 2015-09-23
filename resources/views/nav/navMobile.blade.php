<nav class="nav mobile" data-ng-controller="NavController">
    <div class="overlay" data-ng-click="menuActive=false" data-ng-class="(menuActive) ? 'active' : 'disabled'"></div>
    <section class="mast">
        <h1><a href="#/">Nicholas Headlong</a></h1>
        <span class="menu" data-ng-click="menuActive = !menuActive">&nbsp;</span>
    </section>
    <nav class="nav mobile side-menu" data-ng-class="(menuActive) ? 'active' : 'disabled'">
        <button data-ng-click="menuActive = !menuActive">close menu</button>
        <ul class="menu">
            <li><a data-ng-click="menuActive = !menuActive" href="#projects">Projects</a></li>
            <li><a data-ng-click="menuActive = !menuActive" href="#projlets">Projlets</a></li>
            <li><a data-ng-click="menuActive = !menuActive" href="#skills">Skills</a></li>
            <li><a data-ng-click="menuActive = !menuActive" href="#work-experience">Work Experience</a></li>
            <li><a href="http://blog.nicholasheadlong.co.uk">Blog</a></li>
            <li><a href="/downloads/nihcolasheadlongCv.pdf">CV</a></li>
            <li><a data-ng-click="menuActive = !menuActive" href="#contact">Contact</a></li>
        </ul>
    </nav>
</nav>