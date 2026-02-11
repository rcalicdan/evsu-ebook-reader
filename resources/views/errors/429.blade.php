@extends('errors::minimal')

@section('title', __('Too many request Error'))
@section('code', '429')
@section('message', __('Too many request Error'))
@section('icon', '⚡')
@section('description', 'Something went wrong on our end. Our team has been notified and is working to fix the issue.')