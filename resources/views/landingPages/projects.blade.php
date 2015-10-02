<section class="content projects">
    @if (Auth::check())
        <button class="new-project" data-ng-init="isEditable=!isEditable" data-ng-click="newProject=!newProject">&#43</button>
        <form name="newProjectForm" data-ng-class="(newProject) ? 'active' : 'disabled'" enctype="multipart/form-data"
              data-ng-submit="save(newProjectForm, '{{ $pageType }}', projectData)" novalidate data-ng-upload>
            <div flow-init flow-name="files.images[0].flow" flow-file-success="uploader.controllerFn($flow, $file, $message)">
                <label for="mainImage">First Image</label>
                <input name="mainImage" type="file" flow-btn/>
            </div>
            <input type="text" name="title" data-ng-model="projectData.title" placeholder="Title..."/>
            <label for="description">Main Description</label>
            <textarea data-ng-model="projectData.description" name="description"></textarea>
            <div flow-init flow-name="files.images[1].flow">
                <label for="secondImage">Second Image</label>
                <input name="secondImage" type="file" flow-btn/>
            </div>
            @if ($pageType != 'projlets')
            <label for="moreInfo">More Information</label>
            <textarea data-ng-model="projectData.moreInfo" name="moreInfo"></textarea>
            @endif
            <input type="submit" value="Save"/>
        </form>
    @endif
    <ul data-ng-init="category='{{ $pageType }}'">
        <li data-ng-repeat="project in projects">
            @if(Auth::check())
                <form name="updateProjectForm" class="active" data-ng-submit="update($index, updateProjectForm, this)">
                    <ul class="toolbar">
                        <li tooltip="change image">
                            <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},target: '/api/{{ str_singular($pageType) }}/images/' + project.id + ((project.images[0].id) ? '/' + project.images[0].id : ''), permanentErrors: [415, 500, 501], testChunks:false}"
                                 test-chunks="false"
                                 flow-files-submitted="$flow.upload()"
                                 flow-file-success="uploader.handleImageCallback($flow, $file, $message, $index, 0)">
                                <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                            </div>
                        </li>
                        <li data-ng-click="deleteImage(project.images[0].id, $index, 0)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                        <li data-ng-click="editProjectSelected=!editProjectSelected" tooltip="edit">&#9998;&nbsp;&nbsp;P</li>
                        <li data-ng-click="delete($index, project.id)" tooltip="delete">&#9003;&nbsp;&nbsp;P</li>
                    </ul>
                    <div class="imgWrapper">
                        <img data-ng-if="$flow.files[0]" flow-img="$flow.files[0]" />
                        <img data-ng-if="project.images[0]" data-ng-src="@{{ project.images[0].folderLocation + project.images[0].fileName }}" alt=""/>
                    </div>
                    <h2 data-ng-hide="editProjectSelected" data-ng-bind="project.title"></h2>
                    <input type="text" data-ng-model="this.project.title" placeholder="title..." data-ng-show="editProjectSelected"/>
                    <span class="read-more-icon" data-ng-click="readMoreSelected=!readMoreSelected">&DownArrowUpArrow;</span>
                    <section class="read-more" data-ng-class="(readMoreSelected) ? 'active' : 'disabled'">
                        <section class="description" data-ng-hide="editProjectSelected" data-ng-bind-html="project.description"></section>
                        <textarea name="description" data-ng-model="this.project.description" data-ng-show="editProjectSelected">
                        </textarea>
                        <ul class="toolbar">
                            <li class="two" tooltip="change image">
                                <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},target: '/api/{{ str_singular($pageType) }}/images/' + project.id + ((project.images[1].id) ? '/' + project.images[1].id : ''), permanentErrors: [415, 500, 501], testChunks:false}"
                                     test-chunks="false"
                                     flow-files-submitted="$flow.upload()"
                                     flow-file-success="uploader.handleImageCallback($flow, $file, $message, $index, 1)">
                                    <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                                </div>
                            </li>
                            <li class="two" data-ng-click="deleteImage(project.images[1].id, $index, 1)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                        </ul>
                        <div class="imgWrapper">
                            <img data-ng-if="$flow.files[1]" flow-img="$flow.files[1]" />
                            <img data-ng-if="project.images[1]" data-ng-src="@{{ project.images[1].folderLocation + project.images[1].fileName }}" alt=""/>
                        </div>
                        @if ($pageType != 'projlets')
                            <section class="moreInfo" data-ng-bind-html="project.moreInfo" data-ng-hide="editProjectSelected"></section>
                            <textarea name="moreInfo" data-ng-model="this.project.moreInfo"
                                      data-ng-show="editProjectSelected"></textarea>
                        @endif
                        <h3 data-ng-if="project.skillTags.length>0">Technologies Used:</h3>
                        <ul class="skills" data-ng-if="project.skillTags.length>0" data-ng-hide="editProjectSelected">
                            <li data-ng-repeat="skillTag in project.skillTags" data-ng-bind="skillTag.skill.name"></li>
                        </ul>
                        <select multiple="" data-ng-model="this.project.skillTags" name="skillTags" data-ng-show="editProjectSelected">
                            <option data-ng-repeat="skill in skills" data-ng-value="skill.id" data-ng-bind="skill.name"></option>
                        </select>
                    </section>
                    <input data-ng-show="editProjectSelected" type="submit" value="Update"/>
                </form>
            @else
                <div class="imgWrapper" data-ng-if="project.images[0]">
                    <img data-ng-src="@{{ project.images[0].folderLocation + project.images[0].fileName }}" alt=""/>
                </div>
                <h2 data-ng-bind="project.title"></h2>
                <span class="read-more-icon" data-ng-click="readMoreSelected=!readMoreSelected">&DownArrowUpArrow;</span>
                <section class="read-more" data-ng-class="(readMoreSelected) ? 'active' : 'disabled'">
                    <section class="description" data-ng-bind-html="project.description"></section>
                    <div class="imgWrapper" data-ng-if="project.images[1]">
                        <img data-ng-src="@{{ project.images[1].folderLocation + project.images[1].fileName }}" alt=""/>
                    </div>
                    @if ($pageType != 'projlets')
                        <section class="moreInfo" data-ng-bind-html="project.moreInfo"></section>
                    @endif
                    <h3 data-ng-if="project.skillTags.length>0">Technologies Used:</h3>
                    <ul class="skills" data-ng-if="project.skillTags.length>0">
                        <li data-ng-repeat="skillTag in project.skillTags" data-ng-bind="skillTag.skill.name"></li>
                    </ul>
                </section>
            @endif
        </li>
    </ul>
</section>