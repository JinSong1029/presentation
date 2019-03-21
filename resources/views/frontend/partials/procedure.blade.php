<div class="procedure">
	<ul class="procedure__list">
		@foreach( $slide->slideables() as $slice )
			<li class="procedure__item">
				<div class="procedure-content">
					{!! $slice->desc !!}
				</div>
				<div class="procedure-label">
					{!! $slice->label !!}
				</div>
			</li>
		@endforeach
	</ul>
</div>