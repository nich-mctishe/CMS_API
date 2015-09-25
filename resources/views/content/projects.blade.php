<section class="content projects">
    @if (Auth::check())
        <button class="new-project" data-ng-init="isEditable=!isEditable" data-ng-click="newProject=!newProject">&#43</button>
        <form name="newProjectForm" data-ng-class="(newProject) ? 'active' : 'disabled'" enctype="multipart/form-data"
              data-ng-submit="save(newProjectForm, '{{ $pageType }}', newProjectData)" novalidate data-ng-upload>
            <label for="mainImage">First Image</label>
            <input name="mainImage" data-ng-model="newProjectData.images[0]" type="file" ngf-pattern="'image/*'"
                   accept="image/*" ngf-max-size="20MB" ngf-select/>
            <input type="text" name="title" data-ng-model="newProjectData.title" placeholder="Title..."/>
            <label for="description">Main Description</label>
            <textarea data-ng-model="newProjectData.description" name="description"></textarea>
            <label for="secondImage">Second Image</label>
            <input name="secondImage" data-ng-model="newProjectData.images[1]" type="file" ngf-pattern="'image/*'"
                   accept="image/*" ngf-max-size="20MB" ngf-select/>
            <label for="moreInformation">More Information</label>
            <textarea data-ng-model="newProjectData.moreInformation" name="moreInformation"></textarea>
            <select multiple="" data-ng-model="newProjectData.skillTags" name="skillTags">
                <option data-ng-repeat="skill in skills" data-ng-value="skill.id" data-ng-bind="skill.name"></option>
            </select>
            <input type="submit" value="Save"/>
        </form>
    @endif
    <ul>
        <li data-ng-repeat="project in projects">
            <img data-ng-if="project.image[0]" src="" alt=""/>
            <h2 data-ng-bind="project.title"></h2>
            <span class="date"></span>
            <section class="main-content" data-ng-bind-html="project.description"></section>
            <img data-ng-if="project.image[1]" src="" alt=""/>
            <section class="more-information" data-ng-bind-html="project.moreInformation"></section>
            <ul class="skillTags">
                <li data-ng-repeat="skillTags in project.skillTags"></li>
            </ul>
        </li>
    </ul>
</section>