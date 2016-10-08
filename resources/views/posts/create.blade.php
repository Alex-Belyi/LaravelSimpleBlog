@extends('main')

@section('title', '| Create New Post')

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
        <div class="col-md-8 col-md-offset-2"> <!--12 colums in grid . here 8 col centered.
        2 col empty space left and 2 col empty space right  -->
            <h1>Create New Post</h1>
            <hr>

            {!! Form::open(array('route' => 'posts.store','data-parsley-validate' => '')) !!}
                 {{ Form::label('title', 'Title:') }}
                 {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength'=>'255')) }}  <!--todo: нет проверки-->

                 {{ Form::label('slug', 'Slug:') }}
                 {{ Form::text('slug', null, array('class' =>'form-control', 'required'=>'', 'minlenght'=> '5', 'maxlenght'=>'255')) }}

                 {{ Form::label('category_id', 'Category:') }}
                 <select class="form-control" name="category_id">
                     @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                     @endforeach
                 </select>

                {{ Form::label('tags', 'Tags:') }}
                <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                    <!-- если не добавитьпосле тагс []  то в БД будет сохранятся кол-во выбраных тегов,
                     а не array с ними     -->
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>

                 {{ Form::label('body', 'Post Body:') }}
                 {{ Form::textarea('body',null, array('class' => 'form-control',)) }}

            {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px')) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection


@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>
@endsection


