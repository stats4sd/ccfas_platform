<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li> -->
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon fa fa-newspaper-o"></i>LogFrameworks</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('subactivity') }}'><i class='nav-icon la la-question'></i> Subactivities</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('activity') }}'><i class='nav-icon la la-question'></i> Activities</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('output') }}'><i class='nav-icon la la-question'></i> Outputs</a></li>
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('effect') }}'><i class='nav-icon la la-question'></i> Effects</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('action') }}'><i class='nav-icon la la-question'></i> Actions</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('indicator') }}'><i class='nav-icon la la-question'></i> Indicators</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('indicatorstatus') }}'><i class='nav-icon la la-question'></i> IndicatorStatuses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('indicatorvalue') }}'><i class='nav-icon la la-question'></i> IndicatorValues</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('team') }}'><i class='nav-icon la la-question'></i> Teams</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Users</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('evidence') }}'><i class='nav-icon la la-question'></i> Evidence</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('beneficiary') }}'><i class='nav-icon la la-question'></i> Beneficiaries</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('beneficiarytype') }}'><i class='nav-icon la la-question'></i> BeneficiaryTypes</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-question'></i> Products</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('aim?is_other=true') }}'><i class='nav-icon la la-question'></i> Aims</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('ipflow') }}'><i class='nav-icon la la-question'></i> Ipflows</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('scope') }}'><i class='nav-icon la la-question'></i> Scopes</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('geoboundary') }}'><i class='nav-icon la la-question'></i> GeoBoundaries</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('csaframework') }}'><i class='nav-icon la la-question'></i> CsaFrameworks</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('producttype?is_other=true') }}'><i class='nav-icon la la-question'></i> ProductTypes</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('country') }}'><i class='nav-icon la la-question'></i> Countries</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pillar') }}'><i class='nav-icon la la-question'></i> Pillars</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('system') }}'><i class='nav-icon la la-question'></i> Systems</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('practice') }}'><i class='nav-icon la la-question'></i> Practices</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('element') }}'><i class='nav-icon la la-question'></i> Elements</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('investment') }}'><i class='nav-icon la la-question'></i> Investments</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('mainaction') }}'><i class='nav-icon la la-question'></i> MainActions</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('enableenv') }}'><i class='nav-icon la la-question'></i> EnableEnvs</a></li>