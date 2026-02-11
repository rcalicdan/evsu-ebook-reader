@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('icon', '🚫')
@section('description', 'You don\'t have permission to access this resource. Contact your administrator if you believe this is a mistake.')