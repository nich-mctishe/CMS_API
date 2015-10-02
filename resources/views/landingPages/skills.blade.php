<section class="content skills">
    <ul data-ng-repeat="category in skillCategory">
        <li>
            <h3>@{{ category.name }}:</h3>
            <ul class="sublist">
                <li data-ng-repeat="skill in category.skills">
                    @if (Auth::check())
                        <ul class="toolbar">
                            <li data-ng-click="updateSkillSelected=!updateSkillSelected; formatUpdateForm('skill', this)">edit</li>
                            <li data-ng-click="delete('skill', $index ,skill.id, $parent.$index)">delete</li>
                        </ul>
                        <form name="updateSkillDataForm" data-ng-class="(updateSkillSelected) ? 'active' : 'disabled'" data-ng-submit="update('skill', this, this.updateSkill)" novalidate>
                            <input type="text" name="name" data-ng-model="this.updateSkill.name" placeholder="Name..." data-ng-value="this.skill.name" />
                            <input type="text" name="desc" data-ng-model="this.updateSkill.desc" placeholder="Short Description..." data-ng-value="this.skill.desc" />
                            <input type="submit" value="Save"/>
                        </form>
                        <h3 class="short" data-ng-show="!updateSkillSelected">@{{ skill.name }} <span data-ng-if="skill.desc.length > 0">(@{{ skill.desc }})</span></h3>
                    @else
                        <h3>@{{ skill.name }} <span data-ng-if="skill.desc.length > 0">(@{{ skill.desc }})</span></h3>
                    @endif
                </li>
                @if (Auth::check())
                    <li class="new-skill" data-ng-click="newSkill=!newSkill">add a skill...</li>
                @endif
            </ul>
            @if (Auth::check())
                <form name="newSkillData" data-ng-class="(newSkill) ? 'active' : 'disabled'"
                      data-ng-submit="save(newSkillData, 'skill', skillData, $index, this)" novalidate>
                    <input type="text" name="name" data-ng-model="skillData.name" placeholder="Name..."/>
                    <input type="text" name="desc" data-ng-model="skillData.desc" placeholder="Short Description..."/>
                    <input type="submit" value="Save"/>
                </form>
            @endif
        </li>
    </ul>

</section>