@extends('errors.layout')
@section('title', \App\CPU\Helpers::translate(Service Unavailable', 'error pages'))
@section('code', '503')
@section('message', \App\CPU\Helpers::translate(Service Unavailable', 'error pages'))
