@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
@section('icon', '🔧')
@section('description', 'We\'re currently performing maintenance. We\'ll be back shortly. Thank you for your patience.')