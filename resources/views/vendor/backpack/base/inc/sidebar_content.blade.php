<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li> -->
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('effect') }}'><i class='fas fa-fire'></i> Effects</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('action') }}'><i class='fas fa-compass'></i> Actions</a></li>
@if(backpack_user()->is_admin)
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="	fas fa-server"></i> User Management</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='fas fa-address-card'></i> Users</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('team') }}'><i class='fas fa-users'></i> Teams</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('invitation') }}'><i class='fas fa-envelope'></i> Send an Invitation</a></li>
    </ul>
</li>

<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="fas fa-newspaper"></i> LogFrameworks</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('output') }}'><i class=''></i> Outputs</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('activity') }}'><i class=''></i> Activities</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('subactivity') }}'><i class=''></i> Subactivities</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('milestone') }}'><i class=''></i> Milestones</a></li>
    </ul>
</li>

<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="fas fa-book-open"></i> CsaFrameworks</a>
    <ul class="nav-dropdown-items">
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pillar') }}'><i class=''></i> Pillars</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('system') }}'><i class=''></i> Systems</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('practice') }}'><i class=''></i> Practices</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('element') }}'><i class=''></i> Elements</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('investment') }}'><i class=''></i> Investments</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mainaction') }}'><i class=''></i> MainActions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('enableenv') }}'><i class=''></i> EnableEnvs</a></li>
    </ul>
</li>

<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="fas fa-tachometer-alt"></i> Indicators Fields</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('indicator') }}'><i class=''></i> Indicators</a></li>
        <!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('indicatorvalue') }}'><i class=''></i> IndicatorValues</a></li> -->
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('levelattribution') }}'><i class=''></i> Level of Attributions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('disaggregation') }}'><i class=''></i> Disaggregations</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evidence') }}'><i class=''></i> Evidence</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('beneficiary') }}'><i class=''></i> Beneficiaries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('beneficiarytype') }}'><i class=''></i> Beneficiary Types</a></li>

 </ul>
</li>

<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="fas fa-poll"></i> Actions Fields</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class=''></i> Products</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('aim?is_other=true') }}'><i class=''></i> Aims</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('ipflow') }}'><i class=''></i> Ipflows</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('scope') }}'><i class=''></i> Scopes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('geoboundary') }}'><i class=''></i> GeoBoundaries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('producttype?is_other=true') }}'><i class=''></i> Product Types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('country') }}'><i class=''></i> Countries</a></li>
    </ul>
</li>
@endif