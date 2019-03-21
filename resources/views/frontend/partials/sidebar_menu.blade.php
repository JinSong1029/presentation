<div class="sidebar">
	<div class="sidebar-logo">
		<img src="{{ asset('images/small-wmlogo.png') }}">
	</div>
	<div class="sidebar-home-link">
		<a href="javascript:void(0)" class="js__go_back">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve"><style type="text/css">.st0{enable-background:new ;}.st1{fill:#FFFFFF;}</style><title>home</title><desc>Created with Sketch.</desc><metadata><!--?xpacket begin="&#65279;" id="W5M0MpCehiHzreSzNTczkc9d"?--><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c111 79.158366, 2015/09/25-01:12:00 "> <rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"> <rdf:description rdf:about="" xmlns:dc="http://purl.org/dc/elements/1.1/"> <dc:description> <rdf:alt> <rdf:li xml:lang="x-default">Created with Sketch.</rdf:li> </rdf:alt> </dc:description> <dc:title> <rdf:alt> <rdf:li xml:lang="x-default">home</rdf:li> </rdf:alt> </dc:title> </rdf:description> </rdf:rdf></x:xmpmeta> <!--?xpacket end="w"?--></metadata><g id="Page-2"><g id="Menu" transform="translate(-15.000000, -15.000000)"><g class="st0"><path class="st1" d="M31,23.1c-0.1,0.1-0.2,0.2-0.3,0.2H29v7.3c0,0.1,0,0.2-0.1,0.2C28.8,31,28.8,31,28.7,31h-3.3c-0.1,0-0.2,0-0.2-0.1C25,30.8,25,30.8,25,30.7V25h-4v5.7c0,0.1,0,0.2-0.1,0.2C20.8,31,20.8,31,20.7,31h-3.3c-0.1,0-0.2,0-0.2-0.1C17,30.8,17,30.8,17,30.7v-7.3h-1.7c-0.1,0-0.3-0.1-0.3-0.2c0-0.1,0-0.3,0.1-0.4l7.7-7.7c0.2-0.2,0.3-0.2,0.5,0l7.7,7.7C31,22.9,31,23,31,23.1z"></path></g></g></g></svg>
			<span>Home</span>
		</a>
	</div>
	@if(isset($presentation))
		<div class="sidebar-menu-active">
			<a href="javascript:void(0)" class="active-btn">
				<span></span>
				<span></span>
				<span></span>
			</a>
		</div>

		<div class="sidebar-content">
			<div class="nav-bar-menu">
				<ul class="nav-bar">
					@foreach($presentation->present()->secondarySections as $i => $section)
						@if ($section->additional == 0)
							<li class="nav-bar-item"><a href="javascript:void(0)" class="wmo-menu__link js__goto_section" data-target="section_{{ $i }}">{{ $section->name }}</a></li>
						@endif
					@endforeach
					<li class="nav-bar-item additional">
						<a href="javascript:void(0)">Additional info</a>
					</li>
						<li class="nav-bar-item">
							<a href="/auth/logout">Log out</a>
						</li>
				</ul>
				<ul class="additional-nav-bar">
					@foreach($presentation->present()->secondarySections as $i => $section)
						@if ($section->additional != 0)
							<li><a href="javascript:void(0)" class="wmo-menu__link js__goto_section" data-target="section_{{ $i }}">{{ $section->name }}</a></li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
	@endif
	<div class="sidebar-footer">
		<a href="https://www.walkermorris.co.uk/">www.walkermorris.co.uk</a>
		<p>&copy; copyright Walker Morris LLP {{ date("Y") }}</p>
	</div>
	<a href="javascript:void(0)" class="fullscreen-toggle">
		<img src="{{ asset('images/fullscreen-on.svg') }}" class="fs-on" />
		<img src="{{ asset('images/fullscreen-off.svg') }}" class="fs-off" />
	</a>
	@if(isset($presentation))
		<div class="sidebar-client-logo">
			@if($presentation->image != null && $presentation->image != '')
				<img src="{{ asset('img/presentations/'.$presentation->image) }}"/>
			@else
				<img src="{{ asset('images/cat-client-logo.png') }}"/>
			@endif
		</div>
	@endif
</div>