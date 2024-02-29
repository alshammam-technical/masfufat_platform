@if(1==2)
@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@endif
<script>
    let previousPageURL = document.referrer;
    location.replace(previousPageURL);
</script>

