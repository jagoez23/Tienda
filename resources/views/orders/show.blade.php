@extends('layouts.app')

@section('content')
<div class="container">
    
<order_detail :order_id="{{$id}}"></order_detail>
    
</div>
@endsection