<nav class="sidebar-nav">

    <ul id="sidebarnav">

        <li >
        	<a class="waves-effect waves-dark" href="{!! route('dashboard') !!}">
        	 	<i class="mdi mdi-home"></i>
        	 	<span class="hide-menu">Dashboard</span>
        	</a>
        </li>

        <li>
        	<a class="waves-effect waves-dark" href="{!! route('appusers') !!}" >
        		<i class="mdi mdi-account-multiple"></i>
                <span class="hide-menu">{{trans('lang.app_users')}}</span>
        	</a>
        </li>

        <li>
        	<a class="waves-effect waves-dark" href="{!! route('guestusers') !!}" >
        		<i class="mdi mdi-account-multiple-plus"></i>
                <span class="hide-menu">{{trans('lang.guest_users')}}</span>
        	</a>
        </li>

        <li>
        	<a class="waves-effect waves-dark" href="{!! route('banners') !!}" >
        		<i class="mdi mdi-monitor-multiple"></i>
                <span class="hide-menu">{{trans('lang.banners')}}</span>
        	</a>
        </li>

        <li>
        	<a class="waves-effect waves-dark" href="{!! route('characters') !!}" >
        		<i class="mdi mdi-emoticon"></i>
                <span class="hide-menu">{{trans('lang.characters')}}</span>
        	</a>
        </li>

        <li>
        	<a class="waves-effect waves-dark" href="{!! route('categories') !!}" >
        		<i class="mdi mdi-collage"></i>
                <span class="hide-menu">{{trans('lang.categories')}}</span>
        	</a>
        </li>
        
        <li>
          <a class="waves-effect waves-dark" href="{!! route('subscriptions') !!}" >
            <i class="mdi mdi-cash-usd"></i>
                <span class="hide-menu">{{trans('lang.subscriptions')}}</span>
          </a>
        </li>

        <li>
          <a class="waves-effect waves-dark" href="{!! route('suggestions') !!}" >
            <i class="mdi mdi-cards"></i>
                <span class="hide-menu">{{trans('lang.suggestions')}}</span>
          </a>
        </li>
        <li>
          <a class="waves-effect waves-dark" href="{!! route('notifications') !!}" >
            <i class="mdi mdi-send"></i>
                <span class="hide-menu">{{trans('lang.notifications')}}</span>
          </a>
        </li>
        <li>
          <a class="waves-effect waves-dark" href="{!! route('languages') !!}" >
            <i class="mdi mdi-google-translate"></i>
                <span class="hide-menu">{{trans('lang.languages')}}</span>
          </a>
        </li>

        <li>
          <a class="waves-effect waves-dark" href="{!! route('landingpage') !!}" >
            <i class="mdi mdi-receipt"></i>
                <span class="hide-menu">{{trans('lang.landing_page')}}</span>
          </a>
        </li>
        
        <li>
          <a class="waves-effect waves-dark" href="{!! route('settings.general') !!}" >
            <i class="mdi mdi-wrench"></i>
                <span class="hide-menu">{{trans('lang.general_settings')}}</span>
          </a>
        </li>

        <li>
          <a class="waves-effect waves-dark" href="{!! route('settings.limit') !!}" >
            <i class="mdi mdi-settings"></i>
                <span class="hide-menu">{{trans('lang.limit_settings')}}</span>
          </a>
        </li>

    </ul>
  </nav>

  <?php 
  $setting = App\Models\Setting::find(1);
  ?>

  <p class="version">V:<?php echo $setting->app_version; ?></p>