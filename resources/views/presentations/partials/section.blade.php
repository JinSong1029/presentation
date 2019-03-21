<div class="row morris-section @if($section->name != intro_page_name()) draggable @endif">

    <div class="morris-presentation-block overflow-hidden" data-section-id="{{ $section->id }}">
        @if(! \Request::is('presentations/create') && $section->name != intro_page_name())
            <div class="morris-presentation-block-delete delete_section">
                <a href="#" class="morris-presentation-icons"><i class="fa fa-times"></i></a>
            </div>

            <div class="morris-presentation-block-move">
                <a href="" data-ordering="{!! $section->ordering !!}"
                   class="morris-presentation-icons"><i
                            class="fa fa-arrows move_section"></i></a>
            </div>
            <div class="morris-presentation-block-edit edit_section">
                <a href="#" class="morris-presentation-icons"><i
                            class="fa fa-pencil"></i></a>
            </div>
        @endif
        <div class="col-md-3">
            <div class="morris-section-title">
                <h3 style="margin: 0px;">{!! $section->name !!}</h3>
                <input class="form-control section-name-input" type="text" name="name" style="display: none;">
            </div>
        </div>

        <div class="col-md-12">
            <div class="morris-presentation-section-slides-wrap">
                <div class="morris-presentation-section-slides"
                     @if(isset($presentation))data-presentation-id="{!! $presentation->id !!}"
                     @endif data-id="{!! $section->id !!}" data-order="{{$section->ordering}}">
                    @if($section->slides && !$section->slides->isEmpty())
                        @foreach($section->slides as $index => $slide)
                            @include('presentations.partials.slide')
                        @endforeach
                    @endif
                </div>

                <div class="morris-presentation-slide
                @if($section->name == intro_page_name()) singular @endif"
                     @if($section->name == intro_page_name() && count($section->slides) >=1) style="display: none" @endif
                >
                    @if(! \Request::is('presentations/create'))

                        <a href="#" class="morris-presentation-slide-add"><i class="fa fa-plus"></i></a>

                    @endif
                </div>
            </div>
        </div>


        <div class="morris-section-delete-confirm">

            <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12">
                <a class="btn btn-default btn-block edit_cancel">Cancel</a>
            </div>
            {!! Form::open(['action' => ['Admin\AdminSectionsController@destroy', $section->id],
                    'method'=>'DELETE','id'=>'remove-entry-form']) !!}
            <div class="col-sm-3">
                <a class="btn btn-danger btn-block bg-danger remove_section" href="#">Delete section</a>
            </div>

            {!! Form::close() !!}
        </div>

        <div class="morris-slide-delete-confirm">

            <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12">
                <a class="btn btn-default btn-block edit_cancel">Cancel</a>
            </div>


            <div class="col-sm-3">
                <a data-id="" class="btn btn-danger btn-block bg-danger remove_slide" href="#">Delete slide</a>
            </div>

        </div>

        <div class="morris-section-edit-confirm">

            <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12">
                <a class="btn btn-default btn-block edit_cancel">Cancel</a>
            </div>
            <div class="col-sm-3">
                <a data-section_id="{!! $section->id !!}"
                   class="btn btn-primary btn-block bg-danger update_section" href="#">Update
                    section</a>
            </div>
        </div>
        @if(isset($presentation))
            <div class="row">
                <div class="morris-section-addslide col-xs-12">

                    {!! Form::open(['url' => 'slides', 'method' => 'post','class'=>'morris-create-slide-form', 'id'=>'add_slide_'.$section->id]) !!}
                    {!! Form::hidden('presentationId', $presentation->id) !!}
                    {!! Form::hidden('slidesCount', count($section->slides)) !!}
                    {!! Form::hidden('sectionId', $section->id) !!}
                    @if($section->name == intro_page_name())
                        {!! Form::hidden('singular',true,['id'=>'intro_singular']) !!}
                    @endif
                    @if($section->name == intro_page_name() && count($section->slides))
                        {!! Form::hidden('noMoreSlides',true,['class'=>'singular-no-more']) !!}
                    @endif
                    <div class="form-group col-xs-3">
                        <input type="text" class="form-control" name="name" placeholder="Slide name"/>
                    </div>
                    <div class="form-group col-xs-3">
                        @include('presentations.partials.typesSelect',['section'=>$section])
                    </div>
                    <div class="form-group col-xs-3">
                        <a href="#" class="btn btn-default btn-block morris-presentation-slide-add-cancel">Cancel</a>
                    </div>
                    <div class="form-group col-xs-3 subm">
                        <input type="submit" class="btn btn-primary btn-block " value="Create slide"/>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="validation-errors-slide"></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="morris-section-moveslide col-xs-12">

                    {!! Form::open(['url' => '', 'method' => 'post','class'=>'morris-move-slide-form','id'=>'move_slide_'.$section->id]) !!}
                    {!! Form::hidden('presentationId', $presentation->id) !!}
                    {!! Form::hidden('sectionId', $section->id) !!}

                    <div class="form-group col-xs-3">
                        <a href="#" class="btn btn-default btn-block morris-presentation-slide-move-cancel">Cancel</a>
                    </div>
                    <div class="form-group col-xs-3 col-xs-offset-3">
                        <select name="section" class="form-control morris-presentation-select moveToSectionSelect">
                            <option value="0">Choose section...</option>
                            @foreach($presentation->sections as $sectionItem)
                                @if($sectionItem->id != $section->id)
                                    <option value="{{$sectionItem->id}}">{{$sectionItem->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-xs-3 subm">
                        <input type="submit" class="btn btn-primary btn-block " value="Move slide"/>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        @endif
        <div class="morris-success-message"><i class="fa fa-check"></i> Changes have been saved successfully</div>
        <div class="morris-error-message"><i class="fa fa-check"></i> Error</div>

    </div>
</div>