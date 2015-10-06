
<section class="content work-experience">

    @if (Auth::check())
    <ul class="toolbar">
        <li class="two" data-ng-click="workExperienceFormSelected=!workExperienceFormSelected">employer</li>
        <li class="two" data-ng-click="clientFormSelected=!clientFormSelected">client</li>
    </ul>

    <form name="addClient" data-ng-class="(clientFormSelected) ? 'active' : 'disabled'"
          enctype="multipart/form-data" data-ng-submit="client.save(addClient)">
        <div class="flow" flow-init flow-name="clientFiles.images[0].flow" flow-file-success="uploader.successCallback($flow, $file, $message, 'client')">
            <span class="button" flow-btn>Upload Clients Logo</span>
            <span class="file-name" data-ng-if="clientFiles.images[0].flow">@{{ clientFiles.images[0].flow.files[0].name }}</span>
        </div>
        <input name="name" type="text" data-ng-model="client.data.name" placeholder="Client Name"/>
        <input value="Save" type="submit"/>
    </form>

    <form name="addPreviousEmployer" data-ng-class="(workExperienceFormSelected) ? 'active' : 'disabled'"
          enctype="multipart/form-data" data-ng-submit="workExperience.save(addPreviousEmployer)">
        <div class="flow" flow-init flow-name="workExperienceFiles.images[0].flow" flow-file-success="uploader.successCallback($flow, $file, $message, 'workExperience')">
            <span class="button" flow-btn>Upload Employers Logo</span>
            <span class="file-name" data-ng-if="workExperienceFiles.images[0].flow">@{{ workExperienceFiles.images[0].flow.files[0].name }}</span>
        </div>
        <input name="name" type="text" data-ng-model="workExperience.data.name" placeholder="Employers Name"/>
        <input name="role" type="text" data-ng-model="workExperience.data.role" placeholder="Role"/>
        <label for="description">Description</label>
        <textarea name="description" data-ng-model="workExperience.data.description"></textarea>
        <input type="datetime" ng-model="workExperience.data.dateStarted" placeholder="Date Started">
        <input type="datetime" ng-model="workExperience.data.dateEnded" placeholder="Date Ended">
        <input value="Save" type="submit"/>
    </form>

    @endif

    <section class="past-employers">
        <h2 data-ng-hide="previousExperience<1">Previous Employment</h2>
        <ul>
            @if (Auth::check())
                <li data-ng-repeat="employer in previousExperience">
                    <form class="active" name="updatePreviousEmployer" data-ng-submit="workExperience.update($index, updatePreviousEmployer, this)">
                        @if ($agent->isMobile())
                            <ul class="toolbar">
                                <li tooltip="change image">
                                    <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},target: '/api/workExperience/images/' + employer.id + ((employer.image.id) ? '/' + employer.image.id : ''), permanentErrors: [415, 500, 501], testChunks:false}"
                                         test-chunks="false"
                                         flow-files-submitted="$flow.upload()"
                                         flow-file-success="uploader.handleImageCallback($flow, $file, $message, $index, 0)">
                                        <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                                    </div>
                                </li>
                                <li data-ng-click="workExperience.remove(this, employer.image.id, employer.id)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                                <li data-ng-click="editWorkExperienceSelected=!editWorkExperienceSelected" tooltip="edit">&#9998;&nbsp;&nbsp;E</li>
                                <li data-ng-click="workExperience.remove(this, employer.id)" tooltip="delete">&#9003;&nbsp;&nbsp;E</li>
                            </ul>
                            <div class="imgWrapper">
                                <img data-ng-if="$flow.files[0]" flow-img="$flow.files[0]" />
                                <img data-ng-hide="$flow.files[0]" data-ng-src="@{{ employer.image.folderLocation + employer.image.fileName }}" alt="@{{ employer.name }}"/>
                            </div>
                            <h2 data-ng-show="!editWorkExperienceSelected" data-ng-bind="employer.name"></h2>
                            <input data-ng-show="editWorkExperienceSelected" name="name" type="text"
                                   data-ng-model="this.employer.name" placeholder="Employers Name"/>
                            <h3 data-ng-show="!editWorkExperienceSelected" data-ng-bind="employer.role"></h3>
                            <input data-ng-show="editWorkExperienceSelected" name="role" type="text"
                                   data-ng-model="this.employer.role" placeholder="Role"/>
                            <h3 data-ng-show="!editWorkExperienceSelected">Employment Term:
                                <span class="start">@{{ employer.dateStarted | date: 'MMMM yyyy' }}</span> -
                                <span class="end">@{{ employer.dateEnded | date: 'MMMM yyyy' }}</span>
                            </h3>
                            <input data-ng-show="editWorkExperienceSelected" type="datetime"
                                   data-ng-model="this.employer.dateStarted" placeholder="Date Started">
                            <input data-ng-show="editWorkExperienceSelected" type="datetime"
                                   data-ng-model="this.employer.dateEnded" placeholder="Date Ended">
                            <section data-ng-show="!editWorkExperienceSelected" class="description" data-ng-bind-html="employer.description"></section>
                            <textarea data-ng-show="editWorkExperienceSelected" name="description"
                                      data-ng-model="this.employer.description"></textarea>
                            <input data-ng-show="editWorkExperienceSelected" value="Update" type="submit"/>
                            @else
                            <div class="left-content">
                                <ul class="toolbar">
                                    <li tooltip="change image">
                                        <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},target: '/api/workExperience/images/' + employer.id + ((employer.image.id) ? '/' + employer.image.id : ''), permanentErrors: [415, 500, 501], testChunks:false}"
                                             test-chunks="false"
                                             flow-files-submitted="$flow.upload()"
                                             flow-file-success="uploader.handleImageCallback($flow, $file, $message, $index, 0)">
                                            <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                                        </div>
                                    </li>
                                    <li data-ng-click="workExperience.remove(this, employer.image.id, employer.id)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                                    <li data-ng-click="editWorkExperienceSelected=!editWorkExperienceSelected" tooltip="edit">&#9998;&nbsp;&nbsp;E</li>
                                    <li data-ng-click="workExperience.remove(this, employer.id)" tooltip="delete">&#9003;&nbsp;&nbsp;E</li>
                                </ul>
                                <div class="imgWrapper">
                                    <img data-ng-if="$flow.files[0]" flow-img="$flow.files[0]" />
                                    <img data-ng-hide="$flow.files[0]" data-ng-src="@{{ employer.image.folderLocation + employer.image.fileName }}" alt="@{{ employer.name }}"/>
                                </div>
                            </div>
                            <div class="right-content">
                                <h2 data-ng-show="!editWorkExperienceSelected" data-ng-bind="employer.name"></h2>
                                <input data-ng-show="editWorkExperienceSelected" name="name" type="text"
                                       data-ng-model="this.employer.name" placeholder="Employers Name"/>
                                <h3 data-ng-show="!editWorkExperienceSelected" data-ng-bind="employer.role"></h3>
                                <input data-ng-show="editWorkExperienceSelected" name="role" type="text"
                                       data-ng-model="this.employer.role" placeholder="Role"/>
                                <h3 data-ng-show="!editWorkExperienceSelected">Employment Term:
                                    <span class="start">@{{ employer.dateStarted | date: 'MMMM yyyy' }}</span> -
                                    <span class="end">@{{ employer.dateEnded | date: 'MMMM yyyy' }}</span>
                                </h3>
                                <input data-ng-show="editWorkExperienceSelected" type="datetime"
                                       data-ng-model="this.employer.dateStarted" placeholder="Date Started">
                                <input data-ng-show="editWorkExperienceSelected" type="datetime"
                                       data-ng-model="this.employer.dateEnded" placeholder="Date Ended">
                                <section data-ng-show="!editWorkExperienceSelected" class="description" data-ng-bind-html="employer.description"></section>
                                <textarea data-ng-show="editWorkExperienceSelected" name="description"
                                      data-ng-model="this.employer.description"></textarea>
                                <input data-ng-show="editWorkExperienceSelected" value="Update" type="submit"/>
                            </div>
                        @endif
                    </form>
                </li>
                @else
                <li data-ng-repeat="employer in previousExperience">
                    @if ($agent->isMobile())
                        <div class="imgWrapper">
                            <img data-ng-src="@{{ employer.image.folderLocation + employer.image.fileName }}" alt=""/>
                        </div>
                        <h2 data-ng-bind="employer.name"></h2>
                        <h3 data-ng-bind="employer.role"></h3>
                        <h3>Employment Term:
                            <span class="start">@{{ employer.dateStarted | date: 'MMMM yyyy' }}</span> -
                            <span class="end">@{{ employer.dateEnded | date: 'MMMM yyyy' }}</span>
                        </h3>
                        <section class="description" data-ng-bind-html="employer.description"></section>
                        @else
                        <div class="left-content">
                            <div class="imgWrapper">
                                <img data-ng-src="@{{ employer.image.folderLocation + employer.image.fileName }}" alt=""/>
                            </div>
                        </div>
                        <div class="right-content">
                            <h2 data-ng-bind="employer.name"></h2>
                            <h3 data-ng-bind="employer.role"></h3>
                            <h3>Employment Term:
                                <span class="start">@{{ employer.dateStarted | date: 'MMMM yyyy' }}</span> -
                                <span class="end">@{{ employer.dateEnded | date: 'MMMM yyyy' }}</span>
                            </h3>
                            <section class="description" data-ng-bind-html="employer.description"></section>
                        </div>
                    @endif
                </li>
            @endif
        </ul>

    </section>

    <section class="clients">
        <h2 data-ng-hide="clients.length<1">Previous Clients</h2>
        @if ($agent->isMobile())
        <ul>
        @else
        <ul class="clients">
        @endif
            @if (Auth::check())
                @if ($agent->isMobile())
                    <li data-ng-repeat="company in clients">
                        <form name="updateClientForm" class="active" data-ng-submit="client.update($index, updateClientForm, this)">
                            <ul class="toolbar">
                                <li tooltip="change image">
                                    <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                            target: '/api/{{ str_singular($pageType) }}/images/' + company.id + ((company.image.id) ? '/' + company.image.id : ''),
                                            permanentErrors: [415, 500, 501],
                                            testChunks:false}"
                                         test-chunks="false"
                                         flow-files-submitted="$flow.upload()"
                                         flow-file-success="uploader.successCallback($flow, $file, $message, $index, 0)">
                                        <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                                    </div>
                                </li>
                                <li data-ng-click="client.remove(this, company.image.id, company.id)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                                <li data-ng-click="editClientFormSelected=!editClientFormSelected" tooltip="edit">&#9998;&nbsp;&nbsp;P</li>
                                <li data-ng-click="client.remove(this, company.id)" tooltip="delete">&#9003;&nbsp;&nbsp;P</li>
                            </ul>
                            <div class="imgWrapper">
                                <img data-ng-hide="$flow.files[0]" data-ng-src="@{{ company.image.folderLocation + company.image.fileName }}"
                                     alt="@{{ company.name }}"/>
                                <img data-ng-if="$flow.files[0]" flow-img="$flow.files[0]" />
                            </div>
                            <input data-ng-show="editClientFormSelected" data-ng-model="this.company.name" name="name" type="text"/>
                            <input data-ng-show="editClientFormSelected" value="Update" type="submit"/>
                        </form>
                    </li>
                    @else
                    <li data-ng-repeat="company in clients">
                        <form name="updateClientForm" class="active" data-ng-submit="client.update($index, updateClientForm, this)">
                            <ul class="toolbar">
                                <li tooltip="change image">
                                    <div flow-init="{headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                        target: '/api/{{ str_singular($pageType) }}/images/' + company.id + ((company.image.id) ? '/' + company.image.id : ''),
                                        permanentErrors: [415, 500, 501],
                                        testChunks:false}"
                                         test-chunks="false"
                                         flow-files-submitted="$flow.upload()"
                                         flow-file-success="uploader.successCallback($flow, $file, $message, $index, 0)">
                                        <span flow-btn tooltip="Change Image">&plus;&nbsp;&nbsp;I</span>
                                    </div>
                                </li>
                                <li data-ng-click="client.remove(this, company.image.id, company.id)" tooltip="Delete Image">&#8998;&nbsp;&nbsp;I</li>
                                <li data-ng-click="editClientFormSelected=!editClientFormSelected" tooltip="edit">&#9998;&nbsp;&nbsp;P</li>
                                <li data-ng-click="client.remove(this, company.id)" tooltip="delete">&#9003;&nbsp;&nbsp;P</li>
                            </ul>
                            <div class="imgWrapper">
                                <img data-ng-hide="$flow.files[0]" data-ng-src="@{{ company.image.folderLocation + company.image.fileName }}"
                                     alt="@{{ company.name }}"/>
                                <img data-ng-if="$flow.files[0]" flow-img="$flow.files[0]" />
                            </div>
                            <input data-ng-show="editClientFormSelected" data-ng-model="this.company.name" name="name" type="text"/>
                            <input data-ng-show="editClientFormSelected" value="Update" type="submit"/>
                        </form>
                    </li>
                @endif
                @else
                <li data-ng-repeat="company in clients">
                    <div class="imgWrapper">
                        <img data-ng-src="@{{ company.image.folderLocation + company.image.fileName }}"
                             alt="@{{ company.name }}"/>
                    </div>
                </li>
            @endif
        </ul>

    </section>

</section>