@extends('errors.layout')
@section('title', \App\CPU\Helpers::translate(Unauthorized', 'error pages'))
@section('code', '401')
@section('message', \App\CPU\Helpers::translate(Unauthorized', 'error pages'))
