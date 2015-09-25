<section class="content skills">
    @if (Auth::check())
        <button class="new-category" data-ng-click="newCategory=!newCategory">&#43</button>
        <form name="newSkillCategory" data-ng-class="(newCategory) ? 'active' : 'disabled'"
              data-ng-submit="save(newSkillCategory, 'skillCategory', category)" novalidate>
            <input type="text" name="name" data-ng-model="category.name" placeholder="Name..."/>
            <input type="submit" value="Save"/>
        </form>
    @endif
    <ul data-ng-repeat="category in skillCategory">
        <li>
            @if (Auth::Check())
                <ul class="toolbar">
                    <li data-ng-click="updateCategorySelected=!updateCategorySelected; formatUpdateForm('skillCategory', this)">edit</li>
                    <li data-ng-click="delete('skillCategory', $index ,category.id)">delete</li>
                </ul>
                <h3 class="short" data-ng-show="!updateCategorySelected">@{{ category.name }}:</h3>
                <form name="updateSkillCategoryForm" data-ng-class="(updateCategorySelected) ? 'active' : 'disabled'"
                      data-ng-submit="update('skillCategory', this, this.updateCategory)" novalidate>
                    <input type="text" name="name" data-ng-model="this.updateCategory.name" placeholder="Name..." value="backend"/>
                    <input type="submit" value="Save"/>
                </form>
            @else
            <h3>@{{ category.name }}:</h3>
            @endif
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