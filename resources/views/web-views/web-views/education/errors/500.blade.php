@extends('errors.layout')
@section('title', \App\CPU\Helpers::translate(Server Error', 'error pages'))
@section('code', '500')
@section('message', \App\CPU\Helpers::translate(Server Error', 'error pages'))
