@extends('layouts.backend.app')
@section('title','Create-Post')
@push('css')
@endpush
@section('content')
    <div class="container-fluid">
            <a class="btn btn-danger waves-effect" href="{{route('author.post.index')}}">BACK</a>
            @if($post->is_approved == false)
                <button type="button" class="btn btn-success pull-right ">
                    <i class="material-icons">done</i>
                    <span>Pending</span>
                </button>
            @else
            <button type="button" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
            @endif
            <br><br>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <div class="header">
                            <h2>
                               {{$post->title}}
                                <small>
                                    Posted By <strong><a href="#">{{$post->user->name}}</a></strong> on {{$post->created_at->toFormattedDateString()}}
                                </small>
                            </h2>
                        </div>
                        <div class="body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="card">
                        <div class="header bg-blue">
                            <h2>Categories</h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="label bg-amber">{{$category->name}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-success">
                            <h2>Tags</h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="label bg-cyan">{{$tag->name}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-purple">
                            <h2>Featured Image</h2>
                        </div>
                        <div class="body">
                            <img src="{{Storage::disk('public')->url('post/'.$post->image)}}" class="img-responsive thumbnail">
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@push('js')

@endpush