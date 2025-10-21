@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="section-title gradient-text">💬 الرسائل</h1>
            <p class="text-muted">إدارة محادثاتك مع التجار والمستخدمين الآخرين</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="animated-card text-center py-5">
                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">نظام الرسائل قيد التطوير</h4>
                <p class="text-muted">سيتم إضافة نظام المحادثات قريباً</p>
                <a href="{{ url('/user/dashboard') }}" class="btn btn-modern">العودة للوحة التحكم</a>
            </div>
        </div>
    </div>
</div>
@endsection
