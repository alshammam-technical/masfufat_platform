@extends('errors.layout')
@section('title', \App\CPU\Helpers::translate(Too Many Requests', 'error pages'))
@section('code', '429')
@section('message', \App\CPU\Helpers::translate(Too Many Requests', 'error pages'))
