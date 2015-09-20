<nav class="nav mobile" data-ng-controller="NavController">
    <section class="mast">
        <h1><a href="#">Nicholas Headlong</a></h1>
        <span class="menu" data-ng-click="menuActive = !menuActive">&nbsp;</span>
    </section>
    <nav class="nav mobile side-menu" data-ng-class="(menuActive) ? 'active' : 'disabled'">
        <button data-ng-click="menuActive = !menuActive">close menu</button>
        <ul class="menu">
            <li><a href="#1">Projects</a></li>
            <li><a href="#2">Projlets</a></li>
            <li><a href="#3">Skills</a></li>
            <li><a href="#4">Work Experience</a></li>
            <li><a href="#5">Blog</a></li>
            <li><a href="#6">CV</a></li>
            <li><a href="#7">Contact</a></li>
        </ul>
    </nav>
</nav>