@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')
        {!! Html::style('css/parsley.css') !!}
        {!! Html::style('css/select2.min.css') !!}
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'link code',
                menubar: false

            });
        </script>
@endsection

@section('content')

    <div class="row">

            {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT' ]) !!}

        <div class="col-md-8">

            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', null, ['class' =>  'form-control input-lg', 'required']) }}

            {{ Form::label('slug', 'Slug:', ['class'=> 'form-spacing-top']) }}
            {{ Form::text('slug',null, ['class' => 'form-control', 'required']) }}

            {{ Form::label('category_id', 'Category:') }}
            {{ Form::select('category_id', $categories, null, ['class' => 'form-control'])}} <!-- разобрать -->

            {{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
            {{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}
            <!-- [] array с тегами-->

            {{ Form::label('title', 'Body:', ['class' => 'form-spacing-top' ]) }}
            {{ Form::textarea('body', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <label>Created At:</label>
                    <p>{{ date( 'M j, Y G:i', strtotime($post->created_at)) }}</p>
                </dl>

                <dl class="dl-horizontal">
                    <label>Last Updated:</label>
                    <p>{{ date( 'M j, Y G:i', strtotime($post->updated_at)) }}</p>
                </dl>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                    {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class'=>'btn btn-danger btn-block')) !!}
                    <!--  <a href="#" class="btn btn-primary btn-block">Edit</a> -->
                    </div>
                    <div class="col-sm-6">

                    {{ Form::submit('Save Changes', ['class' => 'btn btn-success  btn-block']) }}

                    </div>
                </div>
            </div>
        </div>
            {!! Form::close() !!}
    </div> <!-- end of the row(form) -->

@stop

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    <script type="text/javascript">
        $('.select2-multi').select2();
        $('.select2-multi').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
    </script>
@endsection