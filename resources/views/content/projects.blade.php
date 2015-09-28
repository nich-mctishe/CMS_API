<section class="content projects">
    @if (Auth::check())
        <button class="new-project" data-ng-init="isEditable=!isEditable" data-ng-click="newProject=!newProject">&#43</button>
        <form name="newProjectForm" data-ng-class="(newProject) ? 'active' : 'disabled'" enctype="multipart/form-data"
              data-ng-submit="save(newProjectForm, '{{ $pageType }}', newProjectData)" novalidate data-ng-upload>
            <div flow-init flow-name="files.images[0].flow" flow-file-success="onFileSuccess($data)">
                <label for="mainImage">First Image</label>
                <input name="mainImage" type="file" flow-btn/>
            </div>
            <input type="text" name="title" data-ng-model="newProjectData.title" placeholder="Title..."/>
            <label for="description">Main Description</label>
            <textarea data-ng-model="newProjectData.description" name="description"></textarea>
            <div flow-init flow-name="files.images[1].flow">
                <label for="secondImage">Second Image</label>
                <input name="secondImage" type="file" flow-btn/>
            </div>
            <label for="moreInfo">More Information</label>
            <textarea data-ng-model="newProjectData.moreInfo" name="moreInfo"></textarea>
            <select multiple="" data-ng-model="newProjectData.skillTags" name="skillTags">
                <option data-ng-repeat="skill in skills" data-ng-value="skill.id" data-ng-bind="skill.name"></option>
            </select>
            <input type="submit" value="Save"/>
        </form>
    @endif
    <ul>
        <li data-ng-repeat="project in projects">
            @if (Auth::check())
                <img data-ng-if="project.image[0]" src="" alt=""/>
                <div flow-init="{target: '/{{ $pageType }}/images/' + project.id + '/' + project.image[0].id}" flow-name="files.images.flow">
                    <label for="mainImage">First Image</label>
                    <input name="mainImage" type="file" flow-btn/>
                </div>
            @else
                <img data-ng-if="project.image[0]" src="" alt=""/>
            @endif
            <h2 data-ng-bind="project.title"></h2>
            <span class="date"></span>
            <section class="main-content" data-ng-bind-html="project.description"></section>
            @if (Auth::check())
                <img data-ng-if="project.image[1]" src="" alt=""/>
                <div flow-init="{target: '/{{ $pageType }}/images/' + project.id + '/' + project.image[1].id}" flow-name="files.images.flow">
                    <label for="mainImage">First Image</label>
                    <input name="mainImage" type="file" flow-btn/>
                </div>
            @else
                <img data-ng-if="project.image[1]" src="" alt=""/>
            @endif
            <section class="more-information" data-ng-bind-html="project.moreInformation"></section>
            <ul class="skillTags">
                <li data-ng-repeat="skillTags in project.skillTags"></li>
            </ul>
        </li>
    </ul>
</section>