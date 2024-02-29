@extends('errors.layout')
@section('title', \App\CPU\Helpers::translate(Forbidden', 'error pages'))
@section('code', '403')
@section('message', \App\CPU\Helpers::translate(Forbidden', 'error pages'))
