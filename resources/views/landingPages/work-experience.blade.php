
<section class="content work-experience">

    <ul class="toolbar">
        <li>add previous employer</li>
        <li>add client</li>
    </ul>

    <form name="addPreviousEmployer" action=""></form>
    <form name="addClient" action=""></form>

    <section class="past-employers">
        <ul>
            @if (Auth::check()))
                <li data-ng-repeat="employer in previousExperience">
                    <form action="" name="updatePreviousEmployer"></form>
                </li>
                @else
                <li data-ng-repeat="employer in previousExperience">
                    <div class="imgWrapper">
                        <img data-ng-src="@{{ employer.images[0].folderLocation + employer.images[0].fileName }}" alt=""/>
                    </div>
                    <h2 data-ng-bind="employer.title"></h2>
                    <h3 data-ng-bind="employer.role"></h3>
                    <h3>Employment Term: <span class="start" data-ng-bind="employer.startDate"></span>
                        <span class="end" data-ng-bind="employer.endDate"></span>
                    </h3>
                    <section class="description" data-ng-bind-html="employer.description"></section>
                </li>
            @endif
        </ul>

    </section>

    <section class="clients">

    </section>

</section>