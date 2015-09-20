<section class="skills">
    <section data-ng-repeat="category in skillCategory">
        <h3 data-ng-bind="category.name"></h3>
        <ul>
            <li data-ng-repeat="skill in skillCatego3ry.skills">
                <p data-ng-bind="skill.name"></p><span class="selector"></span>
                <p data-ng-bind="skill.desc"></p>
            </li>
        </ul>
    </section>
</section>