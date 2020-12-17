@extends(backpack_view('blank'))

@php

    $message = trans('backpack::base.use_sidebar');
    $url = backpack_url('logout');
    $urlText = trans('backpack::base.logout');


    if(!auth()->user()->pw_changed) {
        $message = "It looks like you are using an old or automatically generated password. Please click the button below to go to your account page and change your password.";
        $url = backpack_url('edit-account-info');
        $urlText = "My Account";
    }

    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => $message,
        'button_link' => $url,
        'button_text' => $urlText,
    ];
@endphp